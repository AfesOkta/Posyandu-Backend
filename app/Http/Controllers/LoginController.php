<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller{
    public function authenticate(Request $request){
        // Inputan yg diambil
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            // Jika berhasil login

            return redirect(route('dashboard'));

            //return redirect()->intended('/details');
        }
        // Jika Gagal
        return redirect('login');
    }
}
