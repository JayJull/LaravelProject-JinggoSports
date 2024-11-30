<?php

namespace App\Models;

use App\Mail\ApprovePendaftaran;
use App\Mail\DeclinePendaftaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggotas';
    protected $primaryKey = 'id_anggota';
    protected $fillable = [
        'nama',
        'nim',
        'email',
        'semester',
        'no_telp',
        'cv',
        'jenis_kelamin',
        'status',
        'id_prodi'
    ];
    

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id_prodi');
    }

    public function divisi()
    {
        return $this->belongsToMany(Divisi::class, 'divisi_has_anggotas', 'id_anggota', 'id_divisi');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_anggota', 'id_anggota');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'id_anggota', 'id_anggota');
    }

    public static function getFormPendaftaran()
    {
        $prodi = Prodi::all();
        $divisi = Divisi::all();
        return view('content.pendaftaran.formulir', compact('prodi', 'divisi'));
    }

    public static function postStorePendaftaran(Request $request)
    {
        $request->validate([
            'nama' => [
                'required',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'nim' => 'required',
            'prodi' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required',
            'cv' => 'required|mimes:pdf,doc,docx|max:10240',
            'semester' => 'required',
            'divisi_1' => 'required',
            'divisi_2' => 'nullable|different:divisi_1'
        ], [
            'regex' => 'Nama hanya boleh berisi huruf dan spasi',
            'cv.mimes' => 'CV harus dalam format pdf, doc, atau docx',
        ]);

        try {
            DB::beginTransaction();
            // Cek apakah NIM atau email sudah terdaftar
            $cekPendaftar = Anggota::where('email', $request->email)->first();
            $cekUser = User::where('email', $request->email)->first();

            if ($cekPendaftar || $cekUser) {
                return redirect()->route('home')->with('error', 'NIM atau email sudah terdaftar');
            }

            // Proses file CV jika ada yang diunggah
            $cvFileName = null;
            if ($request->hasFile('cv')) {
                $cvFile = $request->file('cv');
                $cvFileName = time() . '.' . $cvFile->getClientOriginalExtension();
                $cvFile->storeAs('public/cv', $cvFileName);
            }

            // Simpan data ke tabel Anggota
            $anggota = Anggota::create([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'id_prodi' => $request->prodi,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'cv' => $cvFileName,
                'semester' => $request->semester,
                'status' => 'menunggu' // Status awal adalah 'menunggu'
            ]);

            DB::table('divisi_has_anggotas')->insert([
                'id_anggota' => $anggota->id_anggota,
                'id_divisi' => $request->divisi_1
            ]);

            // Masukkan ke tabel divisi_has_anggotas untuk divisi kedua (jika ada)
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
            if (isset($cvFileName)) {
                Storage::delete('public/cv/' . $cvFileName);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mendaftar. Silahkan coba lagi.')
                ->withInput();
        }
    }

    public static function getIndexPendaftaran()
    {
        $dtPendaftaran = Anggota::all();
        return view('content.pendaftaran.index', compact('dtPendaftaran'));
    }

    public static function getDetailDataPendaftaran($id)
    {
        $dtAnggota = Anggota::with(['divisi', 'prodi'])->findOrFail($id);
        if ($dtAnggota->cv) {
            $dtAnggota->cv_base64 = base64_encode($dtAnggota->cv);
        }
        return view('content.pendaftaran.detail', compact('dtAnggota'));
    }

    public static function postDeclinePendaftar($id)
    {
        try {            
            $anggota = Anggota::findOrFail($id);
                        
            $anggota->status = 'ditolak';
            $anggota->save();
                
            Mail::to($anggota->email)->send(new DeclinePendaftaran($anggota));
    
            return redirect()->route('admin-pendaftaran')->with('success', 'Pendaftaran berhasil ditolak. Email pemberitahuan telah dikirim.');
        } catch (\Exception $e) {
            return redirect()->route('admin-pendaftaran')->with('error', 'Terjadi kesalahan saat menolak pendaftaran.');
        }
    }

    public static function postApprovePendaftar($id)
    {
        $anggota = Anggota::findOrFail($id);

        // Update status menjadi diterima
        $anggota->status = 'diterima';
        $anggota->save();

        // Buat user baru untuk anggota yang diterima
        $user = new User();
        $user->id_anggota = $anggota->id_anggota;
        $user->email = $anggota->email;
        $user->token = Str::random(60);  // Generate token aktivasi
        $user->save();

        // Kirim email aktivasi
        Mail::to($anggota->email)->send(new ApprovePendaftaran($anggota, $user->token));

        return redirect()->route('admin-pendaftaran')->with('success', 'Pendaftaran berhasil diterima. Email aktivasi telah dikirim.');
    }

    public static function getSetPassword($token, $email)
    {
        $user = User::where('token', $token)->where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Token aktivasi tidak valid.');
        }
        return view('auth.setpass', compact('token', 'email'));
    }

    public static function postSetPassword(Request $request)
    {        
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);
        
        $user = User::where('token', $request->token)
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Token tidak valid atau sudah digunakan.');
        }

        $user->password = Hash::make($request->password);
        $user->token = null; // Hapus token setelah digunakan
        $user->save();
        
        return redirect()->route('login')->with('success', 'Kata sandi berhasil diatur. Silakan login.');
    }
}
