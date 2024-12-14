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
        'id_divisi',
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
    public static function hapusDivisiNoneDiDataJadwal($dtJadwal){
        // dd($dtJadwal);
        $length = count($dtJadwal);
        for ($i = 0; $i<$length; $i++){//untuk menghilangkan divisi_id 11 dari data jadwal
            if($dtJadwal[$i]->id_divisi == 11){
                unset($dtJadwal[$i]);
            }

        }
    }
}
