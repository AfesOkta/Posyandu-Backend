<?php

namespace App\Http\Controllers;

use App\Repositories\AnggotaRepository;
use App\Repositories\KaderRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $kaderRepo;
    protected $anggotaRepo;
    protected $userRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(KaderRepository $kaderRepo, AnggotaRepository $anggotaRepo, UserRepository $userRepo)
    {
        $this->middleware('auth');
        $this->kaderRepo    = $kaderRepo;
        $this->anggotaRepo  = $anggotaRepo;
        $this->userRepo     = $userRepo;
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

    public function dashboard()
    {   $countKader = 0;
        $countAnggota = 0;
        $userExists     = $this->userRepo->findAksesPosyandu(auth()->user()->id);
        if (auth()->user()->id == 1) {
            foreach ($userExists as $key => $value) {
                # code...
            }
        }else{
            $countKader     = $this->kaderRepo->countPosyandu($userExists[0]->posyandu_kode);
            $countAnggota   = $this->anggotaRepo->countPosyandu($userExists[0]->posyandu_kode);
        }

        // $countKader     = $this->kaderRepo->countPosyandu();
        // $countAnggota   = $this->anggotaRepo->countPosyandu();
        return view('dashboard',[
            "countAnggota"  => $countAnggota,
            "countKader"    => $countKader
        ]);
    }
}
