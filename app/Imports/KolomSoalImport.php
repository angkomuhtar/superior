<?php

namespace App\Imports;

use App\Models\Kolom;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class KolomSoalImport implements ToCollection
{
    protected $id_kelompok_soal;
    public function __construct($id_kelompok_soal){
        $this->id_kelompok_soal = $id_kelompok_soal;
    }
    public function collection(Collection $rows)
    {
        $kolom_name = [];
//        dd($rows->toArray());
        foreach ($rows as $index => $row)
        {
            if ($index === 0){
                foreach ($row AS $item){
                    $kolom_name[] = $item;
                }
            } else {
                $data = [];
                foreach ($row AS $key => $item){
                    $data[$kolom_name[$key]] = $item;
                }
                $data['id_kelompok_soal'] = $this->id_kelompok_soal;
                if (isset($data['soal']) && isset($data['jawaban']) && isset($data['kolom'])) {
                    if ($kolom = Kolom::where('id_kelompok_soal', $this->id_kelompok_soal)->where('soal', $data['soal'])->first()) {
                    } else {
                        if (Kolom::where('id_kelompok_soal', $this->id_kelompok_soal)->where('kolom', $data['kolom'])->first()) {
                            $data['kolom'] = Kolom::where('id_kelompok_soal', $this->id_kelompok_soal)->orderByDesc('kolom')->first()->kolom + 1;
                        }
                        $kolom = Kolom::create($data);
                    }
                    $kolom->soalJawaban()->create($data);
                }
            }
        }
    }
}
