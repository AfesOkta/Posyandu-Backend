<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    }

    public function absensi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" =>  "required|email",
            'posyandu'  => "required",
        ]);
        if ($request->e =="" && $request->p=="") {
            return response()->json(["validation_errors" => $validator->errors()]);
        }


    }
}
