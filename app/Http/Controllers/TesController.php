<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\KelompokSoal;
use App\Models\Peserta;
use App\Models\Setting;
use App\Models\Soal;
use App\Models\Tes;
use Illuminate\Http\Request;

class TesController extends Controller
{
    private function cekAktivasiKode(){
        if (session()->has('aktivasi')) {
            $aktivas = optional(Setting::where('parameter', 'kode_aktivasi')->first())->value;
            if ($aktivas === session('aktivasi')){
                return true;
            }
            session()->remove('aktivasi');
        }
        return false;
    }

    public function halamanDaftar(){
        if ($this->cekAktivasiKode()) {
            if (session()->has('peserta')) {
                return redirect()->to('tes');
            }
            return view('daftar-peserta');
        }
        return redirect()->route('aktivasi');
    }

    public function daftarPeserta(Request $request)
    {
        if ($tes = Tes::with('kelompokSoal.kolom')->whereHas('kelompokSoal')->where('secret_key', $request->secret_key)->where('aktif',1)->first()) {
            $minutes = $tes->batas_waktu * $tes->kelompokSoal->kolom->count();
            $peserta = Peserta::create(array_merge($request->only(['nama_peserta', 'no_telp']), [
                'id_tes' => $tes->id,
                'waktu_mulai_tes' => now(),
                'waktu_selesai_tes' => now()->addMinute($minutes),
                'nama_tes' => $tes->nama_tes
            ]));
            session()->remove('peserta');
            session()->remove('jawaban');
            session()->remove('mulai_tes');
            session(['peserta' => $peserta->id]);
            return redirect()->to('pre-tes');
        }
        return redirect()->back();
    }

    public function preTes(){
        if ($this->cekAktivasiKode()) {
            if (session()->has('peserta') && !session('mulai_tes',false)) {
                $peserta = Peserta::with('tes.kelompokSoal.kolom')->find(session('peserta'));
                return view('pre-tes', compact('peserta'));
            }
            return redirect()->to('daftar-peserta');
        }
        return redirect()->route('aktivasi');
    }

    public function mulaiTes(){
        if ($this->cekAktivasiKode()){
            if (session()->has('peserta')){
                $peserta = Peserta::with('tes.kelompokSoal.kolom')->find(session('peserta'));
                $minutes = $peserta->tes->batas_waktu * $peserta->tes->kelompokSoal->kolom->count();
                $peserta->update([
                    'waktu_mulai_tes' => now(),
                    'waktu_selesai_tes' => now()->addMinute($minutes),
                ]);
                session(['mulai_tes' => true]);
                return redirect()->to('tes');
            }
            return redirect()->to('daftar-peserta');
        }
        return redirect()->route('aktivasi');
    }

    public function batalUjian(){
        if ($this->cekAktivasiKode()) {
            if (session()->has('peserta')) {
                $peserta = Peserta::find(session('peserta'));
                $peserta->delete();
                session()->remove('peserta');
            }
            return redirect()->to('daftar-peserta');
        }
    }

    public function selesaiTes(){
        if ($this->cekAktivasiKode()) {
            if (session()->has('peserta')) {
                session(['mulai_tes' => false]);
                return redirect()->to('hasil-tes');
            }
            return redirect()->to('daftar-peserta');
        }
    }

    public function hasilTes(){
        if (session()->has('peserta') && !session('mulai_tes',false)){
            $peserta = Peserta::with('jawaban','tes.kelompokSoal.kolom.soalJawaban')->find(session('peserta'));
            if ($peserta){
                $jawaban = $peserta->jawaban->filter(function ($item){
                    return $item->jawaban_soal === $item->jawaban_peserta;
                });
                $grouped_answer = $jawaban->groupBy('kolom');
                $hasil = [];
                foreach ($peserta->tes->kelompokSoal->kolom AS $kolom){
                    $hasil[$kolom->kolom] = [
                        'benar' => isset($grouped_answer[$kolom->kolom]) ? $grouped_answer[$kolom->kolom]->count() : 0,
                        'soal' => $kolom->soalJawaban->count()
                    ];
                }
                return view('hasil-tes',compact('peserta','hasil'));
            } else {
                session()->remove('peserta');
                session()->remove('jawaban');
                session()->remove('mulai_tes');
            }
        }
        return redirect()->to('daftar-peserta');
    }

    public function runningTes()
    {
        if (session()->has('peserta') && session('mulai_tes',false)) {
            return view('tes');
        }
        return redirect()->to('daftar-peserta');
    }

    public function getTest()
    {
        if (session()->has('peserta') && session('mulai_tes',false)) {
//        if (true) {
            $id_peserta = session('peserta');
            $peserta = Peserta::with('tes.kelompokSoal.kolom')->find($id_peserta);
            if ($peserta) {
                try {
                    $jumlah_kolom = $peserta->tes->kelompokSoal->kolom->count();
                    $batas_waktu = $peserta->tes->batas_waktu * $jumlah_kolom;
                    $jumlah_menit_setiap_kolom = $peserta->tes->batas_waktu;
                    $waktu_sekarang = now()->format('c');
                    $waktu_selesai = $peserta->waktu_selesai_tes;
                    $waktu_mulai = $peserta->waktu_mulai_tes;
                    $selisih = (strtotime($waktu_sekarang) - strtotime($waktu_mulai)) / 60;
                    $group_kolom = ceil($selisih / $jumlah_menit_setiap_kolom);
                    if ($group_kolom >= 0 && (strtotime($waktu_sekarang) <= strtotime($waktu_selesai))) {
                        $group_kolom = !$group_kolom ? 1 : $group_kolom;
//                        $kolom = $batas_waktu - $group_kolom + 1;
                        $data_kolom = $peserta->tes->kelompokSoal->kolom()->where('kolom', $group_kolom)->first();
                        if ($data_kolom) {
                            $data_kolom->pilihan = $this->str_split_unicode($data_kolom->soal);
                            $data_kolom->soal_jawaban = $data_kolom->soalJawaban()->whereNotIn('id', session('jawaban', []))->orderBy('id', 'asc')->limit(1)->get()->map(function ($value) {
                                $value->soal_pertanyaan = str_replace($value->jawaban, '', $value->soal);
                                $value->soal_shuffle = $this->str_shuffle_unicode($value->soal_pertanyaan);
                                $value->jawaban = '';
                                return $value;
                            });
                            return response()->json([
                                'data' => $data_kolom,
                                'jumlah_menit_setiap_kolom' => $jumlah_menit_setiap_kolom,
                                'waktu_mulai' => $waktu_mulai->format('c'),
                                'waktu_sekarang' => $waktu_sekarang,
                                'waktu_selesai' => $waktu_selesai->format('c')
                            ]);
                        }
                    }
                } catch (\Exception $exception){
                    session()->remove('peserta');
                    session()->remove('jawaban');
                    session()->remove('mulai_tes');
                }
            } else {
                session()->remove('peserta');
                session()->remove('jawaban');
                session()->remove('mulai_tes');
            }
        }
        session(['mulai_tes' => false]);
        return false;
    }

    public function submitJawaban(Request $request)
    {
        $id_peserta = session('peserta');
        $jawaban = $request->jawaban;
        $id_pertanyaan = $request->id_pertanyaan;
        if (!in_array($id_pertanyaan,session('jawaban',[]))) {
            session()->push('jawaban', $id_pertanyaan);
            $soal = Soal::with('kolom')->find($id_pertanyaan);
            Jawaban::create([
                'id_peserta' => $id_peserta,
                'soal' => $soal->soal,
                'jawaban_soal' => $soal->jawaban,
                'jawaban_peserta' => $jawaban,
                'id_soal' => $id_pertanyaan,
                'kolom' => $soal->kolom->kolom
            ]);
        }
    }

    public function clearData(){
        session()->remove('peserta');
        session()->remove('jawaban');
        session()->remove('mulai_tes');
        return redirect()->to('daftar-peserta');
    }

    public function index()
    {
        $tes = Tes::with('kelompokSoal')->get();
        return view('pages.tes.index', compact('tes'));
    }

    public function add()
    {
        $kelompok_soal = KelompokSoal::get();
        $tes = new Tes();
        return view('pages.tes.add', compact('kelompok_soal','tes'));
    }

    public function edit($id){
        $tes = Tes::find($id);
        $kelompok_soal = KelompokSoal::get();
        return view('pages.tes.add',compact('tes','kelompok_soal'));
    }

    public function addPost(Request $request)
    {
        $request->validate([
            'secret_key' => 'required|unique:tes,secret_key'
        ]);
        Tes::create($request->all());
        return redirect()->route('dashboard.tes');
    }

    public function editPost(Request $request,$id){
        $request->validate([
            'secret_key' => 'required|unique:tes,secret_key,'.$id
        ]);
        $tes = Tes::find($id);
        $tes->update($request->all());
        return redirect()->route('dashboard.tes');
    }

    public function deleteTes($id){
        $tes = Tes::find($id);
        $tes->delete();
    }

    public function toggleActiveTes($id){
        $tes = Tes::find($id);
        $tes->update([
            'aktif' => !$tes->aktif
        ]);
    }

    public function str_split_unicode($str, $length = 0) {
        $tmp = preg_split('~~u', $str, -1, PREG_SPLIT_NO_EMPTY);
        if ($length > 1) {
            $chunks = array_chunk($tmp, $length);
            foreach ($chunks as $i => $chunk) {
                $chunks[$i] = join('', (array) $chunk);
            }
            $tmp = $chunks;
        }
        return $tmp;
    }

    public function str_shuffle_unicode($str) {
        $tmp = preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
        shuffle($tmp);
        return join("", $tmp);
    }

    public function previewTes(Request $request){
        $soal = $request->query('soal');
        $soal_array = $this->str_split_unicode($soal);
        return view('preview-tes',compact('soal','soal_array'));
    }
}
