<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';
    protected $primaryKey = "id_peminjaman";
    protected $fillable = [
        'jml_alat',
        'tggl_pinjam',
        'petugas_id',
        'id_alat',
        'id_anggota'
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat', 'id_alat',);
    }

    public function pengembalian()
    {
        return $this->hasOne(Peminjaman::class, 'id_pengembalian', 'id_pengembalian');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
