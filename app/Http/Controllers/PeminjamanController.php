<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// ...


class PeminjamanController extends Controller
{

    public function index()
    {
        $peminjaman = Peminjaman::with('anggota', 'alat')->where('status', 'dipinjam')->get();

        return view('content.peminjaman.index', compact('peminjaman'));
    }


    public function create() // relasi untuk menampilkan nama alat
    {

        $alat = Alat::all();
        $anggota = Anggota::with('prodi')->get();
        //  dd($anggota);
        return view('content.peminjaman.create', compact('alat', 'anggota'));
    }


    public function store(Request $request)
    {
            Peminjaman::pinjam($request);

            return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil dibuat');
    }
}
