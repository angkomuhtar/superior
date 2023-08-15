<?php

namespace App\Http\Controllers;

use App\Imports\KolomSoalImport;
use App\Models\Jawaban;
use App\Models\KelompokSoal;
use App\Models\Kolom;
use App\Models\Soal;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class SoalController extends Controller
{
    public function index(){
        $kelompok_soal = KelompokSoal::get();
        return view('pages.soal.index',compact('kelompok_soal'));
    }

    public function add(){
        $kelompok_soal = new KelompokSoal();
        return view('pages.soal.add',compact('kelompok_soal'));
    }

    public function edit($id){
        $kelompok_soal = KelompokSoal::find($id);
        return view('pages.soal.add',compact('kelompok_soal'));
    }

    public function addPost(Request $request){
        KelompokSoal::create($request->all());
        return redirect()->route('dashboard.soal');
    }

    public function editPost(Request $request,$id){
        $kelompok_soal = KelompokSoal::find($id);
        $kelompok_soal->update($request->all());
        return redirect()->route('dashboard.soal');
    }

    public function deleteKelompokSoal($id){
        $kelompok = KelompokSoal::with('kolom.soalJawaban')->find($id);
        $kelompok->kolom->each(function ($item){
            $item->soalJawaban()->delete();
        });
        $kelompok->kolom()->delete();
        $kelompok->delete();
    }

    public function importKolom(Request $request,$id_kelompok){
        \Excel::import(new KolomSoalImport($id_kelompok),$request->file('kolom_soal'));
        return redirect()->back()->with('success','Berhasil Import Soal');
    }

    public function kolomSoal($id_kelompok){
        $kelompok_soal = KelompokSoal::with('kolom.soalJawaban')->find($id_kelompok);
        if ($kelompok_soal){
            return view('pages.soal.kolom',compact('kelompok_soal'));
        }
        return redirect()->route('dashboard.soal');
    }

    public function addKolom($id_kelompok){
        if ($kelompok = KelompokSoal::with('kolom')->find($id_kelompok)){
            $kolom = $kelompok->kolom->count()+1;
            $data_kolom = new Kolom();
            return view('pages.soal.add-kolom',compact('kelompok','kolom','data_kolom'));
        }
        return redirect()->route('dashboard.soal');
    }

    public function editKolom($id_kelompok,$id){
        if ($kelompok = KelompokSoal::with('kolom')->find($id_kelompok)){
            $kolom = $kelompok->kolom->count()+1;
            $data_kolom = Kolom::find($id);
            return view('pages.soal.add-kolom',compact('kelompok','kolom','data_kolom'));
        }
        return redirect()->route('dashboard.soal');
    }

    public function addKolomPost(Request $request,$id_kelompok){
        $soal = $request->input('soal');
        $soal = (new TesController())->str_split_unicode($soal);
        if (count(array_unique($soal)) < 5){
            $request->validate([
                'harus_unique' => 'required'
            ],[
                'harus_unique.required' => 'soal harus terdiri dari 5 karakter dan tidak boleh sama'
            ]);
        }
        $kelompok_soal = KelompokSoal::find($id_kelompok);
        $kelompok_soal->kolom()->create($request->all());
        return redirect()->route('dashboard.soal.kolom',['id_kelompok' => $id_kelompok]);
    }

    public function editKolomPost(Request $request,$id_kelompok,$id){
        $soal = $request->input('soal');
        $soal = (new TesController())->str_split_unicode($soal);
        if (count(array_unique($soal)) < 5){
            $request->validate([
                'harus_unique' => 'required'
            ],[
                'harus_unique.required' => 'soal harus terdiri dari 5 karakter dan tidak boleh sama'
            ]);
        }
        $kelompok_soal = KelompokSoal::find($id_kelompok);
        $kolom = $kelompok_soal->kolom()->where('id',$id)->first();
        $soal = $kolom->soal;
        $kolom->update($request->except('_token'));
        if ($kolom->soal !== $soal){
            $kolom->soalJawaban()->delete();
        }
        return redirect()->route('dashboard.soal.kolom',['id_kelompok' => $id_kelompok]);
    }

    public function deleteKolom($id_kelompok,$id){
        $kolom = Kolom::with('soalJawaban')->where('id_kelompok_soal',$id_kelompok)->find($id);
        $kolom->soalJawaban()->delete();
        $kolom->delete();
        $reorder = Kolom::where('id_kelompok_soal',$id_kelompok)->get();
        foreach($reorder AS $key => $row){
            $row->kolom = $key+1;
            $row->save();
        }
    }

    public function jawabanSoal($id_kelompok,$id_kolom){
        $kolom = Kolom::with('soalJawaban')->where('id_kelompok_soal',$id_kelompok)->find($id_kolom);
        if ($kolom){
            return view('pages.soal.jawaban-soal',compact('kolom'));
        }
        return redirect()->route('dashboard.soal.kolom',['id_kelompok' => $id_kelompok]);
    }

    public function addJawabanSoal($id_kelompok,$id_kolom){
        $kolom = Kolom::where('id_kelompok_soal',$id_kelompok)->find($id_kolom);
        if ($kolom){
            $jawabanSoal = new Soal();
            return view('pages.soal.add-jawaban-soal',compact('kolom','jawabanSoal'));
        }
        return redirect()->route('dashboard.soal.kolom',['id_kelompok' => $id_kelompok]);
    }

    public function editJawabanSoal($id_kelompok,$id_kolom,$id){
        $kolom = Kolom::where('id_kelompok_soal',$id_kelompok)->find($id_kolom);
        if ($kolom){
            $jawabanSoal = Soal::where('id_kelompok_soal',$id_kelompok)->where('id_kolom',$id_kolom)->find($id);
            return view('pages.soal.add-jawaban-soal',compact('kolom','jawabanSoal'));
        }
        return redirect()->route('dashboard.soal.kolom',['id_kelompok' => $id_kelompok]);
    }

    public function addJawabanSoalPost(Request $request,$id_kelompok,$id_kolom){
        $kolom = Kolom::where('id_kelompok_soal',$id_kelompok)->find($id_kolom);
        if ($kolom){

            $kolom->soalJawaban()->create([
                'soal' => $kolom->soal,
                'jawaban' => $request->jawaban,
                'id_kelompok_soal' => $id_kelompok
            ]);
            return redirect()->route('dashboard.soal.kolom.jawaban',['id_kelompok' => $id_kelompok,'id_kolom' => $id_kolom]);
        }
        return redirect()->route('dashboard.soal.kolom',['id_kelompok' => $id_kelompok]);
    }

    public function editJawabanSoalPost(Request $request,$id_kelompok,$id_kolom,$id){
        $kolom = Kolom::where('id_kelompok_soal',$id_kelompok)->find($id_kolom);
        if ($kolom){
            $kolom->soalJawaban()->where('id',$id)->update([
                'soal' => $kolom->soal,
                'jawaban' => $request->jawaban,
                'id_kelompok_soal' => $id_kelompok
            ]);
            return redirect()->route('dashboard.soal.kolom.jawaban',['id_kelompok' => $id_kelompok,'id_kolom' => $id_kolom]);
        }
        return redirect()->route('dashboard.soal.kolom',['id_kelompok' => $id_kelompok]);
    }

    public function deleteJawabanSoal($id_kelompok,$id_kolom,$id){
        $soal = Soal::where('id_kolom',$id_kolom)->where('id_kelompok_soal',$id_kelompok)->find($id);
        $soal->delete();
    }
}
