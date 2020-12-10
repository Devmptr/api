<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;

use App\User;

class UserController extends Controller
{
    //
    public $success_status = 200;

    public function loginPost(Request $request){
        
        //Validasi Request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Return Response kalau gagal validasi
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            //kalau berhasil login
            $user = Auth::user();
            $success['token'] =  $user->createToken('Laravel API Success Login')->accessToken;
            $success['role'] = $user->role;

            // return response
            return response()->json(['success' => $success], $this->success_status);
        }
        else{
            // return reseponse gagal login / unauthorized
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function registerPost(Request $request){
        
        //Validasi Request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'confirm' => 'required|same:password',
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
        $new_user->role = 'user';
        $new_user->save();

        //create response token dan name(?)
        $success['token'] = $new_user->createToken('Laravel Test API Success Register')->accessToken;
        $success['name'] = $new_user->name;

        //return response
        return response()->json(['success' => $success], $this->success_status);

    }

    public function test(){
        return response()->json(['sucesss' => 'nais'],  $this->success_status);
    }
}
