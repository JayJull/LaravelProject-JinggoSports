<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alats';
    protected $primaryKey = "id_alat";
    protected $fillable = [
        'nama_alat',
        'stok',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }
}
