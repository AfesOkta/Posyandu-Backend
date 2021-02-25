<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    // User Register
    public function register(Request $request) {
        $validator  =   Validator::make($request->all(), [
            "name"  =>  "required",
            "email"  =>  "required|email",
            "phone"  =>  "required",
            "password"  =>  "required"
        ]);

        if($validator->fails()) {
            return response()->json(["status" => "failed", "validation_errors" => $validator->errors()]);
        }

        $inputs = $request->all();
        $inputs["password"] = Hash::make($request->password);

        $user   =   User::create($inputs);

        if(!is_null($user)) {
            return response()->json(["status" => "success", "message" => "Success! registration completed", "data" => $user]);
        }
        else {
            return response()->json(["status" => "failed", "message" => "Registration failed!"]);
        }
    }

    // User login
    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            "email" =>  "required|email",
            //"password" =>  "required",
            'posyandu'  => "required",
        ]);

        if($validator->fails()) {
            return response()->json(["validation_errors" => $validator->errors()]);
        }

        $user = User::where("email", $request->email)->first();
        if(!is_null($user)) {
            $user_posyandu = DB::table('users_posyandu')->where('user_id',$user->id)->where('posyandu_kode',$request->posyandu)->first();

            // if(is_null($user)) {
            //     return response()->json(["status" => "failed", "message" => "Failed! email not found"]);
            // }

            if(!is_null($user_posyandu)){
                $userLogin  =  Auth::loginUsingId($user->id,false);
                if ($userLogin) {
                    $user       =       Auth::user();
                    $token      =       $user->createToken('token')->plainTextToken;

                    return response()->json(["status" => "success", "login" => true, "token" => $token, "data" => $user]);
                }else{
                    return response()->json(["status" => "failed", "message" => "Failed! email not found"]);
                }
            }
            else {
                return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! invalid password"]);
            }
        }else{
            return response()->json(["status" => "failed", "message" => "Failed! email not found"]);
        }
    }


    // User Detail
    public function user() {
        $user       =       Auth::user();
        if(!is_null($user)) {
            return response()->json(["status" => "success", "data" => $user]);
        } else {
            return response()->json(["status" => "failed", "message" => "Whoops! no user found"]);
        }
    }

    public function logout(Request $request) {
        $user = User::where("email", $request->email)->first();
        if(!is_null($user)) {
            $user_posyandu = DB::table('users_posyandu')->where('user_id',$user->id)->where('posyandu_kode',$request->posyandu)->first();
            if(!is_null($user_posyandu)){
                $user = $request->user();
                $user->currentAccessToken()->delete();
                $respon = [
                    'status' => 'success',
                    'msg' => 'Logout successfully',
                    'errors' => null,
                    'content' => null,
                ];
                return response()->json($respon, 200);
            }
        }
    }

    public function logoutall(Request $request) {
        $user = $request->user();
        $user->tokens()->delete();
        $respon = [
            'status' => 'success',
            'msg' => 'Logout successfully',
            'errors' => null,
            'content' => null,
        ];
        return response()->json($respon, 200);
    }
}
