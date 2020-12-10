<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;

use App\AnggotaKeluarga;

class AnggotaKeluargaController extends Controller
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
        $anggota = AnggotaKeluarga::all();
        return response()->json([ 'anggota' => $anggota ], $this->success_status);
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
            'id_keluarga' => 'required'
        ]);

        // Return Response kalau gagal validasi
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $store = new AnggotaKeluarga;
        $store->nama = $request->nama;
        $store->jenis_kelamin = $request->jenis_kelamin;
        $store->tempat_lahir = $request->tempat_lahir;
        $store->tanggal_lahir = $request->tanggal_lahir;
        $store->agama = $request->agama;
        $store->pendidikan = $request->pendidikan;
        $store->pekerjaan = $request->pekerjaan;
        $store->tipe = $request->tipe;
        $store->ayah = $request->ayah;
        $store->ibu = $request->ibu;
        $store->id_keluarga = $request->id_keluarga;
        if($request->has('id_user')){
            if($request->id_user != 0){
                $store->id_user = $request->id_user;
            }
        }
        $store->save();

        return response()->json([
            'success' => 'success'
        ], $this->success_status);
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
        $anggota = AnggotaKeluarga::find($id);
        return response()->json([
            'success' => 'success',
            'anggota' => $anggota
        ], $this->success_status);
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
        $anggota = AnggotaKeluarga::find($id);
        return response()->json([
            'success' => 'success',
            'anggota' => $anggota
        ], $this->success_status);
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
        //Validasi Request
        $validator = Validator::make($request->all(), [
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
        ]);

        // Return Response kalau gagal validasi
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $store = AnggotaKeluarga::find($id);
        $store->nama = $request->nama;
        $store->jenis_kelamin = $request->jenis_kelamin;
        $store->tempat_lahir = $request->tempat_lahir;
        $store->tanggal_lahir = $request->tanggal_lahir;
        $store->agama = $request->agama;
        $store->pendidikan = $request->pendidikan;
        $store->pekerjaan = $request->pekerjaan;
        $store->tipe = $request->tipe;
        $store->ayah = $request->ayah;
        $store->ibu = $request->ibu;
        $store->save();

        return response()->json([
            'success' => 'success'
        ], $this->success_status);
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
        $store = AnggotaKeluarga::find($id);
        $store->delete();

        return response()->json([
            'success' => 'success'
        ], $this->success_status);
    }
}
