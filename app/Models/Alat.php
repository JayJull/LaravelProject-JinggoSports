<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alats';
    protected $primaryKey = "id_alat";
    protected $fillable = [
        'id_alat',
        'nama_alat',
        'stok',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public static function LihatAlat()
    {
            // $user = auth()->user();
            // $logName = $user->name;
            // activity()->inLog($logName)->log('membuka alat');
            $dtAlat = Alat::all();
            return $dtAlat;
    }

    public static function StoreAlat(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required',
            'stok' => 'required|integer'
        ]);

        Alat::create([
            'nama_alat' => $request->nama_alat,
            'stok' => $request->stok,
        ]);
        // $user = auth()->user();
        // $logName = $user->name;
        // activity()->inLog($logName)->log('menambah alat');
        return $request;
    }

    public static function IdEdit($id_alat)
    {

        $alat = Alat::findOrFail($id_alat);
        return $alat;
    }

    public static function updatealat(Request $request, $id_alat)
    {
        $alats = Alat::findOrFail($id_alat);
        $alats->update($request->all());
        // $user = auth()->user();
        // $logName = $user->name;
        // activity()->inLog($logName)->log('mengedit alat');
        return $alats;
    }

    public static function hapusalat($id_alat)
    {
        $alats = Alat::findOrFail($id_alat);
        $alats->delete();
        // $user = auth()->user();
        // $logName = $user->name;
        // activity()->inLog($logName)->log('menghapusalat');
        return $alats;
    }
}
