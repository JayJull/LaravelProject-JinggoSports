<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_anggota', 'id_anggota');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'id_anggota', 'id_anggota');
    }
}
