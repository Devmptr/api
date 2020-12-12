<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Validasi extends Model
{
    //
    protected $table = "validasi";

    protected $fillable = [
        'id_admin', 'id_anggota', 'message', 'validated'
    ];

    public function admin(){
        return $this->belongsTo(User::class, 'id_admin');
    }

    public function anggota(){
        return $this->belongsTo(AnggotaKeluarga::class, 'id_anggota');
    }
}
