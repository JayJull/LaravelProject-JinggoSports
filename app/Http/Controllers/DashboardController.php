<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Divisi;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin|pengurus|anggota');
    }

    public function index()
    {
        $totalPendaftar = Anggota::all()->count();
        $totalDivisi = Divisi::all()->count();
        $pendaftarTerima = Anggota::where('status', 'terima')->count();
        $pendaftarTolak = Anggota::where('status', 'tolak')->count();

        $persentaseTerima = ($pendaftarTerima / $totalPendaftar) * 100;
        $persentaseTolak = ($pendaftarTolak / $totalPendaftar) * 100;


        // $user = auth()->user();
        // $logName = $user->name;
        // activity()->inLog($logName)->log('membuka beranda');
        return view('layouts.dashboard', compact('totalPendaftar', 'totalDivisi', 'pendaftarTerima', 'pendaftarTolak', 'persentaseTerima', 'persentaseTolak'));

    }

}
