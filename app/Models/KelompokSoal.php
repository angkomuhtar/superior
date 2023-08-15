<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokSoal extends Model
{
    use HasFactory;
    protected $table = 'kelompok_soal';
    protected $fillable = [
        'nama_kelompok_soal','aktif'
    ];

    public function soal(){
        return $this->hasMany(Soal::class,'id_kelompok_soal');
    }

    public function kolom(){
        return $this->hasMany(Kolom::class,'id_kelompok_soal');
    }
}
