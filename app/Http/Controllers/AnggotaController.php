<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Divisi;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    public function pendaftaran() {
        $prodi = Prodi::all();
        $divisi = Divisi::all();
        return view('content.pendaftaran.formulir', compact('prodi', 'divisi'));
    }

    public function create_pendaftaran(Request $request) {
        // Validasi input dari pengguna
        $this->validate($request, [
            'nama' => [
                'required',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'nim' => 'required',
            'prodi' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required',
            'cv' => 'nullable|mimes:jpeg,png,jpg|max:10240',
            'semester' => 'required',
            'divisi_1' => 'required',
            'divisi_2' => 'nullable|different:divisi_1'
        ], [
            'regex' => 'Nama hanya boleh berisi huruf dan spasi',
            'cv.mimes' => 'CV harus dalam format jpeg, png, atau jpg',
        ]);

        try {
            DB::beginTransaction();

            // Cek apakah NIM atau email sudah terdaftar
            $cekPendaftar = Anggota::where('nim', $request->nim)
                                ->orWhere('email', $request->email)
                                ->first();
            
            $cekUser = User::where('nim', $request->nim)
                            ->orWhere('email', $request->email)
                            ->first();

            if ($cekPendaftar || $cekUser) {
                return redirect()->route('home')->with('error', 'NIM atau email sudah terdaftar');
            }

            // Proses file CV jika ada yang diunggah
            $imageName = null;
            if ($request->hasFile('cv')) {
                $image = $request->file('cv');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/cv', $imageName);
            }

            // Simpan data ke tabel Anggota
            $anggota = Anggota::create([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'id_prodi' => $request->prodi,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'cv' => $imageName,
                'semester' => $request->semester,
                'status' => 'menunggu' // Sesuai dengan default value di migration
            ]);

            // Simpan data ke tabel divisi_has_anggotas untuk pilihan pertama
            DB::table('divisi_has_anggotas')->insert([
                'id_anggota' => $anggota->id_anggota,
                'id_divisi' => $request->divisi_1
            ]);

            // Simpan data ke tabel divisi_has_anggotas untuk pilihan kedua jika ada
            if ($request->divisi_2) {
                DB::table('divisi_has_anggotas')->insert([
                    'id_anggota' => $anggota->id_anggota,
                    'id_divisi' => $request->divisi_2
                ]);
            }

            DB::commit();
            return redirect()->route('landing-page')
                ->with('success', 'Pendaftaran berhasil, pantengin notifikasi emailnya ya!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Hapus file CV jika ada error
            if (isset($imageName)) {
                Storage::delete('public/cv/' . $imageName);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mendaftar. Silahkan coba lagi.')
                ->withInput();
        }
    }

    public function index_pendaftaran(){
        $dtPendaftaran = Anggota::all();
        return view('content.pendaftaran.index', compact('dtPendaftaran'));
    }

    public function approve_pendaftaran($id_anggota, $id_divisi) {
        try {
            DB::beginTransaction();

            // Update status anggota
            $anggota = Anggota::findOrFail($id_anggota);
            $anggota->status = 'diterima';
            $anggota->save();

            // Hapus semua relasi divisi yang tidak dipilih
            DB::table('divisi_has_anggotas')
                ->where('id_anggota', $id_anggota)
                ->where('id_divisi', '!=', $id_divisi)
                ->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Pendaftaran berhasil disetujui');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui pendaftaran');
        }
    }
}