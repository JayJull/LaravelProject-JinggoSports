<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class Presensi extends Model    
{
    use HasFactory;

    protected $table = 'presensis';
    protected $primaryKey = "id_presensi";
    protected $fillable = [
        'id_presensi',
        'tanggal',
        'bukti',
        'id_anggota',
        'id_divisi'
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    

    public static function store(Request $request){
        $user = Auth()->user();
        $anggota = Anggota::where('id_user', $user->id)->first();
        $idDivisi = $anggota->divisi->pluck('id_divisi');
        
        $data_jadwal = Jadwal::whereIn('id_divisi', $idDivisi)->first();
        $tenggat = $data_jadwal->waktu_selesai;
        $validator = Validator::make($request->all(), [
            'tanggal' => 'nullable',
            'id_divisi' => 'required',
            'bukti' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ], [
            'bukti.required' => 'Upload foto dulu',
        ]);

        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:00'); // Ambil waktu sekarang

       
        //dd($currentTime);
        if ($validator->fails()) {
            return redirect()->route('view-presensi')->with('error', 'uplod bukti dulu');
        }

        $fotoFile = $request->file('bukti');
        if (!$fotoFile) {
            return redirect()->route('view-presensi')->with('error', 'Wajib upload bukti');
        }

        $namaFileUnik = Str::uuid() . '' . time() . '' . $fotoFile->getClientOriginalName();
        $fotoPath = $fotoFile->storeAs('public/buktiPresensi', $namaFileUnik);
        
        
        $cek = Presensi::where([
            'id_anggota' => $anggota->id_anggota,
            'id_divisi'=> $request->id_divisi,
            'tanggal' => $currentDate,
        ])->first();
        
        if ($cek) {
            return redirect()->route('view-presensi')->with('error', 'Anda sudah presensi');
        } else {
            if ($currentTime > $tenggat) {
                return redirect()->route('view-presensi')->with('error', 'Presensi ditutup');
            } else {
                Presensi::create([
                    'id_anggota' => $anggota->id_anggota,
                    'bukti'=>$namaFileUnik,
                    'tanggal' => $currentDate,
                    'id_divisi'=>$request->id_divisi
                    // 'bukti' => $namaFileUnik,
                ]);
                return redirect()->route('view-presensi')->with('toast_success', 'Berhasil presensi');
            }
        }
    }


    public static function takePendaftar(){
        $user = Auth::user();
        $anggota = Anggota::find($user->id);
        // $pendaftar = Anggota::where('nim', $anggota->nim)->first();
        // dd($anggota);    
        return $anggota;
    }
    // public static function takeJadwal1(){
    //     $user = Auth::user();
    //     $jadwalDivisi1 = collect(); // Inisialisasi sebagai koleksi kosong
    //     $pendaftar = Anggota::where('nim', $user->nim)->first();
    //     if ($pendaftar) {
    //         if ($pendaftar->divisi_1) {
    //             $divisi1 = Divisi::where('nama', $pendaftar->divisi_1)->first();
    //             if ($divisi1) {
    //                 $jadwalDivisi1 = Jadwal::where('divisi_id', $divisi1->id)->get();
    //             }
    //         }
    //     }
    //     return $jadwalDivisi1;
    // }
    public static function takeJadwal2(){
        $user = Auth::user();
        $anggota = Anggota::find($user->id);  // Cari anggota dengan id = 1

        // Ambil semua id_divisi yang terkait dengan anggota tersebut
        $idDivisi = $anggota->divisi->pluck('id_divisi');
        
        // Ambil semua jadwal yang terkait dengan id_divisi yang didapat
        $jadwalDivisi = Jadwal::whereIn('id_divisi', $idDivisi)->get();
        
        return $jadwalDivisi;
    }
    public static function takeActiveDivisi(){
        $user = Auth::user();
        $anggota = Anggota::find($user->id);
        $idDivisi = $anggota->divisi->pluck('id_divisi');
        $namaDivisi = Divisi::whereIn('id_divisi', $idDivisi)->get();
        return $namaDivisi;
    }
    public static function takeNamaDivisi(){
        $user = Auth::user();
        $anggota = Anggota::find($user->id);  // Cari anggota dengan id = 1

        // Ambil semua id_divisi yang terkait dengan anggota tersebut
        $divisi = $anggota->divisi->pluck('nama');
        // dd($divisi);
        return $divisi;
    }
    public static function takeCek1(){
        $user = Auth::user();
        $anggota = Anggota::find($user->id);  // Cari anggota dengan id = 1

        $id_divisi = $anggota->divisi->pluck('id_divisi');
        // dd($id_divisi[0]);
        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:00'); // Ambil waktu sekarang
        $cek1 = Presensi::where([
            'tanggal' => $currentDate,
            'id_anggota' => $anggota->id_anggota,
            'id_divisi'=>$id_divisi[0],
        ])->first();

        $statusPresensi1 = 'belum presensi';
        
        if ($cek1) {
            # code...
            $statusPresensi1 = 'sudah presensi';
        }
        return $statusPresensi1;
}
public static function takeCek2(){
    $statusPresensi2 = '';
    $user = Auth::user();
    $anggota = Anggota::find($user->id);  // Cari anggota dengan id = 1
    $id_divisi = $anggota->divisi->pluck('id_divisi');
    // dd($id_divisi[0]);
        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:00'); // Ambil waktu sekarang

    $cek2 = Presensi::where([
        'tanggal' => $currentDate,
        'id_anggota' => $anggota->id_anggota,
        'id_divisi'=>$id_divisi[1],
    ])->first();
    if ($cek2) {
        $statusPresensi2 = 'sudah presensi';   
    }
    return $statusPresensi2;
}
    // public static function input(Request $request){
    //     $presensi = Presensi::store($request);
    //         return redirect()->route('view-presensi');
    // }

    public static function viewPresensi(){
        $dtJadwal = Jadwal::with('divisi')->get(); // Eager loading relasi
        $dtDivisi = Divisi::all();
        return view('content.presensi.aktivasi', compact('dtJadwal', 'dtDivisi'));
    }

    public static function updateStatus(Request $request){
        $request->validate([
            'tenggat' => 'required|date_format:H:i',  // Validasi format waktu
        ]);
    
        $jadwal = Jadwal::findOrFail($request->id);
        $jadwal->aktifasi = ($request->status === 'active');
        $jadwal->tenggat = $request->tenggat;
        $jadwal->save();
    
        return response()->json([
            'message' => 'Status dan tenggat berhasil diperbarui!',
            'status' => $jadwal->aktifasi ? 'active' : 'inactive'
        ]);
    }

    public static function takeStatus(Request $request){
        $jadwal = Jadwal::findOrFail($request->id);
    
        // Gunakan accessor di model untuk status
        return response()->json(['status' => $jadwal->aktifasi ? 'active' : 'inactive']);
    }
}
