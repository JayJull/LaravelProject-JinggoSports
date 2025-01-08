<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    public function viewAnggota($id)
    {
        $id = decrypt($id);
        $divisi = Divisi::findOrFail($id);
        $anggota = $divisi->anggota;

        foreach ($anggota as $item) {
            $user = User::where('id_anggota', $item->id_anggota)->first();
            if ($user) {
                $item->gambar = $user->gambar;
                // dd($anggota);
            }
        }

        return view('content.divisi.viewAnggota', compact('divisi', 'anggota', 'user'));
    }
}
