<?php

namespace App\Http\Controllers;

use App\Models\Aktifasi;
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
    // $dtJadwal = Jadwal::all();//

    // $pendaftar = Presensi::takePendaftar();//
    $jadwalDivisi2 = Presensi::takeJadwal2();
    // $dtDivisi = Divisi::all();//
    $namaDivisi = Presensi::takeNamaDivisi();
    $statusPresensi1 = Presensi::checkPresensi(0);//
    $statusPresensi2 = Presensi::checkPresensi(1);//
    // $divisiAktif = Presensi::takeActiveDivisi();//

    // $statusAktifasi = Jadwal::getAktifasiAttribute();
    // dd($namaDivisi);
    $dtAktifasi = Aktifasi::takeAktifasi();
    // dd($dtAktifasi[0][0]->status);
    for($i=0; $i<count($dtAktifasi); $i++){
        for($j = 0; $j<count($dtAktifasi[$i]); $j++){

            if($dtAktifasi[$i][$j]->status == 0){

                unset($dtAktifasi[$i][$j]);
                // dd($dtAktifasi[$i][$j]);
                // dd($dtAktifasi[$i][$j]);
            }
        }

    }
    // dd($dtAktifasi);
    return view('content.presensi.index', compact('dtAktifasi','namaDivisi', 'jadwalDivisi2','statusPresensi1', 'statusPresensi2'));
}
    public function inputPresensi(Request $request){
        $presensi = Presensi::store($request);
        return $presensi;
    }
    public function cetak_presensi(){
        $dtPresensi = Presensi::cetakPresensi();
        $data = $dtPresensi['data'];
        // dd($data);
        return view ('content.presensi.cetakPresensi', compact('data'));
    }


    public function activatePresensiView()
{
    $dtPresensi = Presensi::viewActivatePresensi();

    return $dtPresensi;
}

    public function view(){

        $data = Presensi::dataPresensi();
        // dd($data);
        return $data;
    }


public function toggleStatus(Request $request)
{
    $updateStatus = Presensi::updateStatus($request);
    return $updateStatus;
}

// public function getStatus(Request $request)
// {
//     $status = Presensi::takeStatus($request);
//     return $status;
// }
public function activate(Request $request, $id){
    $aktivasi = Presensi::aktifasi($request, $id);
    return $aktivasi;
}

    public function Scanner(Request $request)
    {
        // dd($request->nim);
        $scan = Presensi::Scan($request->nim);
        // dd($scan);
        return $scan;
    }
}
