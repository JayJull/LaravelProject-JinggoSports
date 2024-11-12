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
        'id_anggota',
        'id_alat',
        'jml_alat',
        'tggl_pinjam',
        'petugas_id'
    ];


     // Method to create a new borrowing
     public static function pinjam($data)
     {
         // Find the alat (tool) by ID
         $alat = Alat::where('id_alat', $data['id_alat'])->firstOrFail();
         
         // Check if stock is sufficient
         $alat->kurangStok($data['jml_alat']);
 
         // Find anggota (member) by NIM
         $anggota = Anggota::where('nim', $data['nim'])->first();
         if (!$anggota) {
             throw new \Exception('NIM tidak ditemukan');
         }
 
         // Create a new borrowing record
         return self::create([
             'id_anggota' => $anggota->id_anggota,
             'id_prodi' => $anggota->id_prodi,
             'id_alat' => $data['id_alat'],
             'jml_alat' => $data['jml_alat'],
             'tggl_pinjam' => $data['tggl_pinjam'],
             'petugas_id' => $data['petugas_id'],
             'status' => 'dipinjam',
         ]);
     }
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat');
    }
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'id_peminjaman');
    }


}