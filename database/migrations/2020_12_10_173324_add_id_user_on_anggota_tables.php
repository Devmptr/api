<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdUserOnAnggotaTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('anggota_keluarga', function (Blueprint $table) {
            $table->foreignId('id_keluarga');
            $table->foreignId('id_user')->nullable();
        });
        
        Schema::table('anggota_keluarga', function (Blueprint $table) {
            $table->foreign('id_keluarga')->references('id')->on('keluarga');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
