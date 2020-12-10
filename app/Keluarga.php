<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    //
    protected $table = 'keluarga';

    protected $fillable = [
        'nomor', 'alamat', 'rtrw', 'kodepos', 'kelurahan',
        'kecamatan', 'kabupaten', 'provinsi'
    ];
}
