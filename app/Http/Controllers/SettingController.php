<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\KelompokSoal;
use App\Models\Peserta;
use App\Models\Setting;
use App\Models\Soal;
use App\Models\Tes;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $setting = Setting::get();
        return view('pages.setting',compact('setting'));
    }

    public function update(Request $request){
        $data = $request->input();
        foreach ($data AS $key => $value){
            if ($setting = Setting::where('parameter',$key)->first()){
                $setting->update(['value'=>$value]);
            } else {
                Setting::create([
                    'parameter' => $key,
                    'value' => $value
                ]);
            }
        }

        return redirect()->back()->with(['success' => 'Pengaturan Berhasil Disimpan']);
    }
}
