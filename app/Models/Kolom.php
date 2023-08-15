<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kolom extends Model
{
    use HasFactory;
    protected $table = 'kolom';
    protected $fillable = [
        'id_kelompok_soal','soal','kolom'
    ];

    public function soalJawaban(){
        return $this->hasMany(Soal::class,'id_kolom');
    }

    public function kelompokSoal(){
        return $this->belongsTo(KelompokSoal::class,'id_kelompok_soal');
    }
}
