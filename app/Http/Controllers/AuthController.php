<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AuthController extends Controller
{
    public function login(){
        if (auth()->check()){
            return redirect()->route('dashboard.tes');
        }
        return view('login');
    }

    public function doLogin(Request $request){
        if (auth()->attempt($request->only(['email','password']))){
            return redirect()->route('dashboard.tes');
        }
        return redirect()->back();
    }

    public function logout(){
        auth()->logout();
        return redirect()->to('');
    }

    public function halamanAktivasi(){
        if (session()->has('aktivasi')){
            return redirect()->to('daftar-peserta');
        }
        return view('aktivasi');
    }

    public function aktivasiSubmit(Request $request){
        $kode_aktivasi = optional(Setting::where('parameter','kode_aktivasi')->first())->value;
        if ($kode_aktivasi){
            if ($kode_aktivasi === $request->aktivasi){
                session(['aktivasi' => $request->aktivasi]);
                return redirect()->to('daftar-peserta');
            }
        }
        return redirect()->back();
    }

    public function aktivasiRevoke(){
        session()->forget('aktivasi');
    }
}
