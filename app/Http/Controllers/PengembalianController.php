<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PengembalianController extends Controller
{
    public function index()
    {
        $dtpengembalian = Pengembalian::all();
        $dataList = Pengembalian::with('peminjaman.anggota')->get();
        return view('content.pengembalian.index', compact('dtpengembalian', 'dataList'));
    }

    public function create($id_peminjaman)
    {

        $dtpeminjaman = Peminjaman::findOrFail($id_peminjaman);
        // Pass the data to the create view
        return view('content.pengembalian.kembali', compact('dtpeminjaman',));
    }

    public function store(Request $request)
    {
        $user = Auth::id();
        $data = $request->validate([
            'id_peminjaman' => 'required|exists:peminjamans,id_peminjaman',
            'tggl_kembali' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // validasi image
        ]);

        // Menyimpan data image jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/pengembalian', 'public');
        }

        // Menambahkan petugas_id ke data
        $data['petugas_id'] = $user;
        $pengembalian = Pengembalian::kembali($data);

        // Handle the return process
        try {
            return redirect()->route('pengembalian')->with('toast_success', 'Data berhasil dikembalikan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }




    public function destroy(string $id_pengembalian)
    {
        $alat = Pengembalian::findOrFail($id_pengembalian);
        $alat->delete();
        return back()->with('toast_success', 'Data Berhasil Dihapus');
    }
}
