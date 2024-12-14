<?php

namespace App\Http\Controllers;

use App\Models\Aktifasi;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {

        $validate = User::validasi($request);
        return $validate;


        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Mohon konfirmasi bahwa anda bukan robot.');
        }
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)) {
            //setelah login update status pada aktifasi menjadi 0 jika sudah melewati tenggat
            $currentTime = Carbon::now()->format('H:i:s'); // Ambil waktu sekarang
            $currentDate = Carbon::now()->format('Y-m-d');//Ambil tanggal sekarang
            $aktifasi = Aktifasi::all();
            // dd($aktifasi);
            $length = count($aktifasi);
            for ($i = 0; $i<$length; $i++){

                $tanggalAktifasi = $aktifasi[$i]->tanggal;
                $tenggatAktifasi = $aktifasi[$i]->tenggat;
                if($currentDate>$tanggalAktifasi || $currentTime>$tenggatAktifasi){
                    $aktifasi[$i]->update([
                        'status'=>0,
                    ]);
                }
            }
            return redirect()->route('view-presensi')->with('success', 'Kamu Berhasil Login');
        } else {
            return redirect()->route('login')->with('error', 'Email atau Password Salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
