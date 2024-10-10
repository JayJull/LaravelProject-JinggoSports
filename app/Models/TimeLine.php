<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $table = 'time_lines';
    protected $primaryKey = "id_timeline";
    protected $fillable = [
        'nama',
        'waktu_mulai',
        'waktu_berakhir',
        'status',
    ];
}
