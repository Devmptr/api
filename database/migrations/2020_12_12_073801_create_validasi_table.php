<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_admin");
            $table->foreignId("id_anggota");
            $table->text("message");
            $table->enum('validated', ['problem', 'validated']);
            $table->timestamps();
        });
        
        Schema::table('validasi', function (Blueprint $table) {
            $table->foreign('id_admin')->references('id')->on('users');
            $table->foreign('id_anggota')->references('id')->on('anggota_keluarga');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('validasi');
    }
}
