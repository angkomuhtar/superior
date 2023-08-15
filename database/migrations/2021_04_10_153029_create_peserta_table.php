<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->string('nama_peserta');
            $table->string('no_telp');
            $table->integer('skor')->default(0);
            $table->foreignId('id_tes');
            $table->string('nama_tes');
            $table->dateTime('waktu_mulai_tes')->nullable();
            $table->dateTime('waktu_selesai_tes')->nullable();
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
        Schema::dropIfExists('peserta');
    }
}
