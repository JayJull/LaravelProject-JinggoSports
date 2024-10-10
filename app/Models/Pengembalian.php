<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';
    protected $primaryKey = "id_pengembalian";
    protected $fillable = [
        'jml_alat',
        'tggl_pinjam',
        'image',
        'deskripsi',
        'tggl_kembali',
        'petugas_id',
        'id_peminjaman'
    ];

    public function peminjaman()
    {
        $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjman');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

}
