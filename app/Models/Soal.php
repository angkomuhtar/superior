<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    protected $table = 'soal';
    protected $fillable = [
        'id_kolom','soal','jawaban','id_kelompok_soal'
    ];

    public function kelompokSoal(){
        return $this->belongsTo(KelompokSoal::class,'id_kelompok_soal');
    }

    public function kolom(){
        return $this->belongsTo(Kolom::class,'id_kolom');
    }
}
