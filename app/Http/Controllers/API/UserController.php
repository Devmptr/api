<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;

use App\User;
use App\AnggotaKeluarga;
use App\Keluarga;

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
            $role = $user->role;

            $checkProfile = AnggotaKeluarga::where("id_user", $user->id)->first();
            
            if (isset($checkProfile)){
                $is_profile_filled = true;
            }else{
                $is_profile_filled = false;
            }

            // return response
            return response()->json(['success' => $success, 'role' => $role,
                                     'is_profile' => $is_profile_filled, 'id' => $user->id], $this->success_status);
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

    public function profileUpdate($id, Request $request){
        //Validasi Request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Return Response kalau gagal validasi
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        //encrypt plain text password
        $encrypted_password = bcrypt($request->password);

        //buat user baru
        $new_user = User::find($id);
        $new_user->name = $request->name;
        $new_user->email = $request->email;
        $new_user->password = $encrypted_password;
        $new_user->save();

        //return response
        return response()->json(['success' => "successfully update user"], $this->success_status);
    }

    public function setFbToken($id, Request $request){
        $user = User::find($id);

        if (isset($user)){
            $user->fb_token = $request->token;
            if($user->save()){
                return response()->json(['success' => 'berhasil set token'], $this->success_status);
            }else{
                return response()->json(['error' => 'gagal set token'], 401);
            }
        }else{
            return response()->json(['error' => 'user not found'], 401);
        }
    }

    public function deleteFbToken($id){
        
        $user = User::find($id);

        if (isset($user)){
            $user->fb_token = Null;
            
            if($user->save()){
                return response()->json(['success' => 'berhasil delete token'], $this->success_status);
            }else{
                return response()->json(['error' => 'gagal set token'], 401);
            }
        }else{
            return response()->json(['error' => 'user not found'], 401);
        }
    }

    public function sendFbNotif(Request $request){
        //Validasi Request
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'message' => 'required',
            'token' => 'required'
        ]);

        // Return Response kalau gagal validasi
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "to" : "'. $request->token .'",
            "notification" : {
                "body" : "'. $request->title .'",
                "title" : "'. $request->message .'"
            },
            "data" : {
                "body" : "'. $request->title .'",
                "message" : "'. $request->message .'"
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: key=AAAAun8XHPU:APA91bFrmAkREgFp11WWJJ3er6lHPAjq2Pa3Jb22H19WN7Xz0i-sJjnNDu3n4nwm1xECrqgRx6p_MWyiqPwBwkDp23HKiCzPskM-VMwjvidWoPmaTbJBsnCc4OoQmqU4sn2HBX0aVifK'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return response()->json(['success' => 'success send notification'], $this->success_status);
    }

    public function getUserKeluarga($id){
        $user = User::find($id);

        if(isset($user)){
            $keluarga = Keluarga::find($user->id_keluarga);
            if(isset($keluarga)){
                return response()->json(['keluarga' => $keluarga], 200);
            }else{
                return response()->json(['error' => 'keluarga not found'], 401);
            }
        }else{
            return response()->json(['error' => 'user not found'], 401);
        }
    }

    public function updateUserKeluarga($id, Request $request){
        $validator = Validator::make($request->all(), [
            'alamat' => 'required',
            'rtrw' => 'required',
            'kodepos' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required'
        ]);

        // Return Response kalau gagal validasi
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = User::find($id);

        if(isset($user)){
            $keluarga = Keluarga::find($user->id_keluarga);
            if(isset($keluarga)){
                $keluarga->alamat = $request->alamat;
                $keluarga->rtrw = $request->rtrw;
                $keluarga->kodepos = $request->kodepos;
                $keluarga->kelurahan = $request->kelurahan;
                $keluarga->kecamatan = $request->kecamatan;
                $keluarga->kabupaten = $request->kabupaten;
                $keluarga->provinsi = $request->provinsi;
                $keluarga->save();

                return response()->json(['success' => 'success update keluarga'], 200);
            }else{
                return response()->json(['error' => 'keluarga not found'], 401);
            }
        }else{
            return response()->json(['error' => 'user not found'], 401);
        }
    }
}
