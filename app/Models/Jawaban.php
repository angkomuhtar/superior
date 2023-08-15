<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;
    protected $table = 'jawaban_peserta';
    protected $fillable = [
        'id_peserta','soal','jawaban_soal','jawaban_peserta','id_soal','kolom'
    ];

    public function peserta(){
        return $this->belongsTo(Peserta::class,'id_peserta');
    }

    public function soal(){
        return $this->belongsTo(Soal::class,'id_soal');
    }
}
