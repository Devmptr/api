<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaKeluargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota_keluarga', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('id_keluarga');
            $table->string('nama', 50);
            $table->string('nik', 20)->nullable();
            $table->enum('jenis_kelamin', ['LAKI-LAKI', 'PEREMPUAN']);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->string('agama', 20);
            $table->string('pendidikan', 50);
            $table->string('pekerjaan');
            $table->enum('tipe', ['suami', 'istri', 'anak']);
            $table->string('ayah', 50);
            $table->string('ibu', 50);
            $table->timestamps();
        });

        // Schema::table('anggota_keluarga', function (Blueprint $table) {
        //     $table->foreign('id_keluarga')->references('id')->on('keluarga');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anggota_keluarga');
    }
}
