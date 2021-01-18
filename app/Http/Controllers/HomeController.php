<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function doLogin(Request $request){
        DB::connection('mysql');
        $args = $request->except('_token');

        // attempt to do the login
        if (Auth::attempt($args)) {
            // validation successful!
            return redirect('dashboard');
        } else {
            // validation not successful, send back to form
            return redirect('login');
        }

    }
}
