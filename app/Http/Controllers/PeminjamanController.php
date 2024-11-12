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
        $validatedData = $request->validate([
            'nim' => 'required|max:12',
            'prodi' => 'required',
            'id_alat' => 'required|exists:alats,id_alat',
            'jml_alat' => 'required|integer|min:1',
            'tggl_pinjam' => 'required|date',
        ]);

        try {
            $validatedData['petugas_id'] = auth()->user()->id;
            Peminjaman::pinjam($validatedData);

            return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil dibuat');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
