<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_peserta')->constrained('peserta');
            $table->string('soal');
            $table->char('jawaban_soal');
            $table->char('jawaban_peserta');
            $table->integer('kolom');
//            $table->foreignId('id_soal')->constrained('soal');
            $table->unsignedBigInteger('id_soal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jawaban_peserta');
    }
}
