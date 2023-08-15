<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;
    protected $table = 'peserta';
    protected $fillable = [
        'nama_peserta','no_telp','skor','id_tes','waktu_mulai_tes','waktu_selesai_tes','nama_tes'
    ];
    protected $dates = [
        'waktu_selesai_tes','waktu_mulai_tes'
    ];

    public function tes(){
        return $this->belongsTo(Tes::class,'id_tes');
    }

    public function jawaban(){
        return $this->hasMany(Jawaban::class,'id_peserta');
    }
}
