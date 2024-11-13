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
        // Mendapatkan ID pengguna yang sedang login
        $userId = Auth::id();

        // Validasi input dari request
        $validatedData = $request->validate([
            'id_peminjaman' => 'required|exists:peminjamans,id_peminjaman', // Memastikan ID peminjaman ada
            'tggl_kembali' => 'required|date', // Validasi tanggal kembali
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi format gambar
        ]);

        // Cek apakah ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            // Simpan gambar ke folder 'public/pengembalian' dan simpan path-nya di $validatedData['image']
            $validatedData['image'] = $request->file('image')->store('pengembalian', 'public');
        }

        // Menambahkan ID petugas ke dalam data yang divalidasi
        $validatedData['petugas_id'] = $userId;

        // Menggunakan model Pengembalian untuk menyimpan data
        try {
            Pengembalian::kembali($validatedData);
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
