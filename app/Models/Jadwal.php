<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals';
    protected $primaryKey = "id_jadwal";
    protected $fillable = [
        'hari',
        'waktu_mulai',
        'waktu_selesai',
        'aktifasi',
        'id_divisi'
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }
}
