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
    public function kurangStok($quantity)
    {
        if ($this->stok < $quantity) {
            throw new \Exception('Stok alat tidak mencukupi.');
        }
        
        $this->stok -= $quantity;
        $this->save();
    }
   
}

