<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tes', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tes');
            $table->string('secret_key');
            $table->boolean('aktif')->default(1);
            $table->integer('batas_waktu');
//            $table->foreignId('id_kelompok_soal')->constrained('kelompok_soal');
            $table->unsignedBigInteger('id_kelompok_soal');
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
        Schema::dropIfExists('tes');
    }
}
