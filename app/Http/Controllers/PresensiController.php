<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Divisi;
use App\Models\Jadwal;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

class PresensiController extends Controller
{
    //
    public function index(Request $request)
{
    $dtJadwal = Jadwal::all();
    $pendaftar = Presensi::takePendaftar();
    $jadwalDivisi2 = Presensi::takeJadwal2();
    $dtDivisi = Divisi::all();
    $namaDivisi = Presensi::takeNamaDivisi();
    $statusPresensi1 = Presensi::takeCek1();
    $statusPresensi2 = Presensi::takeCek2();
    $divisiAktif = Presensi::takeActiveDivisi();
    
    // $statusAktifasi = Jadwal::getAktifasiAttribute();
    // dd($namaDivisi);
    return view('content.presensi.index', compact('dtJadwal','divisiAktif','namaDivisi', 'pendaftar', 'jadwalDivisi2', 'dtDivisi', 'statusPresensi1', 'statusPresensi2'));
}
    public function inputPresensi(Request $request){
        $presensi = Presensi::store($request);
        return $presensi;
    }

    
    public function activatePresensiView()
{
    $dtPresensi = Presensi::viewPresensi();
    return $dtPresensi;
}

public function toggleStatus(Request $request)
{
    $updateStatus = Presensi::updateStatus($request);
    return $updateStatus;
}

public function getStatus(Request $request)
{
    $status = Presensi::takeStatus($request);
    return $status;
}

}
