<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $table = 'divisis';
    protected $primaryKey = "id_divisi";
    protected $fillable = [
        'nama',
    ];

    public function anggota()
    {
        return $this->belongsToMany(Anggota::class, 'divisi_has_anggotas', 'id_divisi', 'id_anggota');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
