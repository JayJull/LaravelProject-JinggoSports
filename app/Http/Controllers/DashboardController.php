<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // dd(auth()->user()->getRoleNames());
        // $totalPendaftar = Pendaftaran::all()->count();
        // $totalDivisi = Divisi::all()->count();
        // $pendaftarTerima = Pendaftaran::where('status', 'terima')->count();
        // $pendaftarTolak = Pendaftaran::where('status', 'tolak')->count();

        // $persentaseTerima = ($pendaftarTerima / $totalPendaftar) * 100;
        // $persentaseTolak = ($pendaftarTolak / $totalPendaftar) * 100;


        // dd(auth()->user()->getRoleNames());

        // if (auth()->user()->can('view_dashboard')) {
        //     return view('dashboard.index', compact('totalPendaftar', 'totalDivisi', 'pendaftarTerima', 'pendaftarTolak', 'persentaseTerima', 'persentaseTolak'));
        // }
        // return abort(403); // keamanan lewat controller
        // $user = auth()->user();
        // $logName = $user->name;
        // activity()->inLog($logName)->log('membuka beranda');
        // return view('layouts.dashboard');
        return view("welcome");

    }
}