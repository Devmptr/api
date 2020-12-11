<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Keluarga;
use App\AnggotaKeluarga;

use Validator;

class KeluargaController extends Controller
{
    public $success_status = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $keluarga = Keluarga::all();
        return response()->json([
            'success' => 'success',
            'data' => $keluarga
        ], $this->success_status);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validasi Request
        $validator = Validator::make($request->all(), [
            'alamat' => 'required',
            'rtrw' => 'required',
            'kodepos' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
        ]);

        // Return Response kalau gagal validasi
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $new = new Keluarga;
        $new->alamat = $request->alamat;
        $new->rtrw = $request->rtrw;
        $new->kodepos = $request->kodepos;
        $new->kelurahan = $request->kelurahan;
        $new->kecamatan = $request->kecamatan;
        $new->kabupaten = $request->kabupaten;
        $new->provinsi = $request->provinsi;
        $new->save();

        return response()->json(['success' => 'success'], $this->success_status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function firstLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'alamat' => 'required',
            'rtrw' => 'required',
            'kodepos' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'agama' => 'required',
            'pendidikan' => 'required',
            'pekerjaan' => 'required',
            'tipe' => 'required',
            'ayah' => 'required',
            'ibu' => 'required',
            'id_user' => 'required'
        ]);

        // Return Response kalau gagal validasi
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }
        
        $keluarga = new Keluarga;
        $keluarga->alamat = $request->alamat;
        $keluarga->rtrw = $request->rtrw;
        $keluarga->kodepos = $request->kodepos;
        $keluarga->kelurahan = $request->kelurahan;
        $keluarga->kecamatan = $request->kecamatan;
        $keluarga->kabupaten = $request->kabupaten;
        $keluarga->provinsi = $request->provinsi;
        if($keluarga->save()){
            $anggota = new AnggotaKeluarga;
            $anggota->nama = $request->nama;
            $anggota->jenis_kelamin = $request->jenis_kelamin;
            $anggota->tempat_lahir = $request->tempat_lahir;
            $anggota->tanggal_lahir = $request->tanggal_lahir;
            $anggota->agama = $request->agama;
            $anggota->pendidikan = $request->pendidikan;
            $anggota->pekerjaan = $request->pekerjaan;
            $anggota->tipe = $request->tipe;
            $anggota->ayah = $request->ayah;
            $anggota->ibu = $request->ibu;
            $anggota->id_keluarga = $keluarga->id;
            $anggota->id_user = $request->id_user;
            if($anggota->save()){
                return response()->json(['success' => 'success'], $this->success_status);
            }
        }
    }
}
