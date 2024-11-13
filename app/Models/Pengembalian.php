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
        'id_pengembalian',
        'id_peminjaman',
        'tggl_kembali',
        'image',
        'petugas_id'
    ];

    public static function kembali($data)
    {
        // Create a new Pengembalian entry
        $pengembalian = self::create($data);

        // Update the Peminjaman status to 'dikembalikan'
        $peminjaman = Peminjaman::find($data['id_peminjaman']);
        if ($peminjaman) {
            $peminjaman->status = 'dikembalikan';
            $peminjaman->save();

            // Update the Alat stock
            $alat = Alat::find($peminjaman->id_alat); // Assuming 'id_alat' refers to id in the alat table
            if ($alat) {
                $alat->stok += $peminjaman->jml_alat; // Add the returned alat quantity back to stock
                $alat->save();
            }
        }

        return $pengembalian;
    }
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
   
    
}