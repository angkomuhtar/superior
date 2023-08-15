<?php

namespace App\Http\Controllers;

use App\Models\Peserta;

class PesertaController extends Controller
{
    public function index()
    {
        $peserta = Peserta::with('jawaban.soal.kolom.soalJawaban','tes.kelompokSoal.kolom.soalJawaban')->orderByDesc('id')->get();

        $peserta = $peserta->map(function ($item){
            $item->jawaban = $item->jawaban->filter(function ($item){
                return $item->jawaban_soal === $item->jawaban_peserta;
            });
            $item->jawaban =$item->jawaban->groupBy('kolom');
            $hasil = [];
            if ($item->tes) {
                foreach ($item->tes->kelompokSoal->kolom as $kolom) {
                    $hasil[$kolom->kolom] = [
                        'benar' => isset($item->jawaban[$kolom->kolom]) ? $item->jawaban[$kolom->kolom]->count() : 0,
                        'soal' => $kolom->soalJawaban->count()
                    ];
                }
                $item->hasil = $hasil;
            } else {
                $item->hasil = $item->jawaban;
            }
            return $item;
        });
        return view('pages.peserta',compact('peserta'));
    }
}
