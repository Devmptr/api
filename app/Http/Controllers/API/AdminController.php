<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Keluarga;
use App\Validasi;
use App\AnggotaKeluarga;

use Validator;

class AdminController extends Controller
{
    // CRUD USER
    public function getUser(){
        $user = User::all();
        
        return response()->json([
            'success' => 'fetch all user',
            'user' => $user
        ], 200);
    }

    public function showUser($id){
        $user = User::find($id);

        if(isset($user)){
            return response()->json([
                'success' => 'fetch one user',
                'user' => $user
            ], 200);
        }else{
            return response()->json([
                'error' => 'user not found'
            ], 401);
        }
    }

    public function createUser(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required'
        ]);

        // Return Response kalau gagal validasi
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        //encrypt plain text password
        $encrypted_password = bcrypt($request->password);

        //buat user baru
        $new_user = new User;
        $new_user->name = $request->name;
        $new_user->email = $request->email;
        $new_user->password = $encrypted_password;
        $new_user->role = $request->role;
        if($new_user->save()){
            return response()->json([
                'success' => 'success to create user'
            ], 200);
        }else{
            return response()->json([
                'error' => 'failed to create user'
            ], 401);
        }
    }
    
    public function updateUser(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required'
        ]);

        // Return Response kalau gagal validasi
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = User::find($id);
        if(!isset($user)){
            return response()->json([
                'error' => 'user not found'
            ], 401);
        }

        //encrypt plain text password
        $encrypted_password = bcrypt($request->password);

        //buat user baru
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $encrypted_password;
        $user->role = $request->role;
        if($user->save()){
            return response()->json([
                'success' => 'success to update user'
            ], 200);
        }else{
            return response()->json([
                'error' => 'failed to update user'
            ], 401);
        }
    }
    
    public function deleteUser($id){
        $user = User::find($id);
        if(!isset($user)){
            return response()->json([
                'error' => 'user not found'
            ], 401);
        }else{
            if($user->delete()){
                return response()->json([
                    'success' => 'user deleted'
                ], 200);
            }else{
                return response()->json([
                    'error' => 'failed to delete user'
                ], 401);
            }
        }
    }

    //CRUD KELUARGA
    public function getKeluarga(){
        $keluarga = Keluarga::all();
        
        return response()->json([
            'success' => 'fetch all keluarga',
            'keluarga' => $keluarga
        ], 200);
    }

    public function showKeluarga($id){
        $keluarga = Keluarga::find($id);

        if(isset($keluarga)){
            return response()->json([
                'success' => 'fetch one keluarga',
                'keluarga' => $keluarga
            ], 200);
        }else{
            return response()->json([
                'error' => 'keluarga not found'
            ], 401);
        }
    }

    public function createKeluarga(Request $request){
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
        if($new->save()){
            return response()->json([
                'success' => 'success to create keluarga'
            ], 200);
        }else{
            return response()->json([
                'error' => 'failed to create keluarga'
            ], 401);
        }
    }
    
    public function updateKeluarga(Request $request, $id){
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

        $keluarga = Keluarga::find($id);
        if(!isset($keluarga)){
            return response()->json([
                'error' => 'keluarga not found'
            ], 401);
        }

        $keluarga->alamat = $request->alamat;
        $keluarga->rtrw = $request->rtrw;
        $keluarga->kodepos = $request->kodepos;
        $keluarga->kelurahan = $request->kelurahan;
        $keluarga->kecamatan = $request->kecamatan;
        $keluarga->kabupaten = $request->kabupaten;
        $keluarga->provinsi = $request->provinsi;
        if($keluarga->save()){
            return response()->json([
                'success' => 'success to update keluarga'
            ], 200);
        }else{
            return response()->json([
                'error' => 'failed to update keluarga'
            ], 401);
        }

    }
    
    public function deleteKeluarga($id){
        $keluarga = Keluarga::find($id);
        if(!isset($keluarga)){
            return response()->json([
                'error' => 'keluarga not found'
            ], 401);
        }else{
            if($keluarga->delete()){
                return response()->json([
                    'success' => 'keluarga deleted'
                ], 200);
            }else{
                return response()->json([
                    'error' => 'failed to delete keluarga'
                ], 401);
            }
        }
    }

    //CRUD ANGGOTA
    public function getAnggota(){
        $anggota = AnggotaKeluarga::all();
        
        return response()->json([
            'success' => 'fetch all anggota',
            'anggota' => $anggota
        ], 200);
    }

    public function showAnggota($id){
        $anggota = AnggotaKeluarga::find($id);

        if(isset($anggota)){
            return response()->json([
                'success' => 'fetch one anggota',
                'anggota' => $anggota
            ], 200);
        }else{
            return response()->json([
                'error' => 'anggota not found'
            ], 401);
        }

    }

    public function createAnggota(Request $request){
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
        $anggota->id_keluarga = $request->id_keluarga;
        
        if($request->has('email_user')){
            if($request->email_user != "NULL"){
                $getUser = User::where("email", $request->email_user)->first();
                if(isset($getUser)){
                    $anggota->id_user = $getUser->id_user;
                }else{
                    return response()->json([
                        'error' => 'failed to get users'
                    ], 401);
                }
            }
        }

        if($request->has("validasi")){
            $anggota->validated = $request->validasi;
        }

        if($anggota->save()){
            return response()->json([
                'success' => 'success to create anggota'
            ], 200);
        }else{
            return response()->json([
                'error' => 'failed to create anggota'
            ], 401);
        }
    }
    
    public function updateAnggota(Request $request, $id){
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

        $anggota = AnggotaKeluarga::find($id);
        if(!isset($anggota)){
            return response()->json([
                'error' => 'anggota not found'
            ], 401);
        }
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
        $anggota->id_keluarga = $request->id_keluarga;
        
        if($request->has('email_user')){
            if($request->email_user != "NULL"){
                $getUser = User::where("email", $request->email_user)->first();
                if(isset($getUser)){
                    $anggota->id_user = $getUser->id_user;
                }else{
                    return response()->json([
                        'error' => 'failed to get users'
                    ], 401);
                }
            }
        }

        if($request->has("validasi")){
            $anggota->validated = $request->validasi;
        }

        if($anggota->save()){
            return response()->json([
                'success' => 'success to update anggota'
            ], 200);
        }else{
            return response()->json([
                'error' => 'failed to update anggota'
            ], 401);
        }

    }
    
    public function deleteAnggota($id){
        $anggota = AnggotaKeluarga::find($id);
        if(!isset($anggota)){
            return response()->json([
                'error' => 'anggota not found'
            ], 401);
        }else{
            if($anggota->delete()){
                return response()->json([
                    'success' => 'anggota deleted'
                ], 200);
            }else{
                return response()->json([
                    'error' => 'failed to delete anggota'
                ], 401);
            }
        }
    }

    public function keluargaAnggota($id){
        $anggota = AnggotaKeluarga::where('id_keluarga', $id)->get();
        
        return response()->json([
            'success' => 'fetch keluarga anggota',
            'anggota' => $anggota
        ], 200);
    }

    //VALIDASI
    public function validasiAnggota(Request $request, $id){

    }
}
