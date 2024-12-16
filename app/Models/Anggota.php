<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        return $this->belongsTo(Divisi::class, 'id_divisi', 'id_divisi');
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_anggota', 'id_anggota');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'id_anggota', 'id_anggota');
    }
        public function jabatan()
    {
        return $this->belongsToMany(Jabatan::class, 'jabatan_has_anggotas', 'id_anggota', 'id_jabatan');
    }

    public function divisis()
    {
        return $this->belongsToMany(Divisi::class, 'divisi_has_anggotas', 'id_anggota', 'id_divisi');
    }

    public static function ViewJabatan()
    {
        $dtPengurus = Anggota::with(['jabatan', 'divisis'])->get();
        return $dtPengurus;
    }

    public static function TambahJabatan($id_anggota)
    {
        $dtAnggota = Anggota::with(['jabatan', 'divisis'])->findOrFail($id_anggota);
        $jabatans = Jabatan::all();
        $divisis = Divisi::all();
        // dd($dtAnggota->id_anggota);
        return [
            'dtAnggota' => $dtAnggota,
            'jabatans' => $jabatans,
            'divisis' => $divisis,
        ];
    }

    public static function InsertJabatan(Request $request, $id_anggota)
    {
        $request->validate([
            'jabatan' => 'required|exists:jabatans,id_jabatan',
        ]);

        $anggota = Anggota::with(['jabatan', 'user'])->findOrFail($id_anggota);

        if ($anggota->jabatan->contains('id_jabatan', $request->jabatan)) {
            return redirect()->back()->withErrors(['jabatan' => 'Jabatan ini sudah diberikan kepada anggota.']);
        }

        $anggota->jabatan()->attach($request->jabatan);

        // Ambil user dari anggota
        $user = $anggota->user;


        $pendaftar = User::find($id_anggota);
        // dd($pendaftar);
        $pendaftar->assignRole('pengurus');

        $pendaftar = Anggota::find($id_anggota);
        $pendaftar->update([
            'jabatan' => "pengurus",
        ]);
        // $user = auth()->user();
        // $logName = $user->name;
        // activity()->withProperties($pendaftar)->inLog($logName)->log('membuat akun pengurus pada user '.$pendaftar->nama);
        return true;
    }

    public static function RemoveJabatan(Request $request, $id_anggota)
    {
        $request->validate([
            'jabatan' => 'required|exists:jabatans,id_jabatan',
        ]);

        $anggota = Anggota::with(['jabatan', 'user'])->findOrFail($id_anggota);

        // Hapus jabatan yang sudah ada di tabel pivot jika ada
        if ($anggota->jabatan->contains('id', $request->jabatan)) {
            $anggota->jabatan()->detach($request->jabatan);  // Menghapus jabatan yang sudah ada
        }

        // Tambahkan jabatan ke tabel pivot
        $anggota->jabatan()->detach ($request->jabatan);

        // Ambil user dari anggota
        $user = $anggota->user;

        $pengurus = User::findOrFail($id_anggota);
        $pengurus->removeRole('pengurus');

        $pendaftar = Anggota::find($id_anggota);
        $pendaftar->update([
            'jabatan' => NULL,
        ]);

        // Optional: Menambahkan log aktivitas (jika diperlukan)
        // $logName = auth()->user()->name;
        // activity()->withProperties($anggota)->inLog($logName)->log('Menambahkan jabatan pengurus pada anggota '.$anggota->nama);

        return true;
    }


}
