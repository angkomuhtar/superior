<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tes extends Model
{
    use HasFactory;
    protected $table = 'tes';
    protected $fillable = [
        'nama_tes','secret_key','aktif','batas_waktu','id_kelompok_soal'
    ];

    public function kelompokSoal(){
        return $this->belongsTo(KelompokSoal::class,'id_kelompok_soal');
    }

    public function peserta(){
        return $this->hasMany(Peserta::class,'id_tes');
    }
}
