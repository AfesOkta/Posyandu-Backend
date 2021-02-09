<?php

namespace App\Http\Controllers;

use App\Models\AbsensiPosyandu;
use App\Models\LansiaPosyandu;
use App\Repositories\AnggotaRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    //
    protected $userRepository;
    protected $lansiaRepository;
    public function __construct(UserRepository $userRepository, AnggotaRepository $anggotaRepository) {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->anggotaRepository = $anggotaRepository;
    }

    public function absensi_anggota_masuk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" =>  "required|email",
            'posyandu'  => "required",
        ]);
        if ($request->e =="" && $request->p=="") {
            return response()->json(["validation_errors" => $validator->errors()]);
        }

        $existsUser = $this->userRepository->findUserByEmailAndPosyandu($request->e, $request->p);
        if (!is_null($existsUser)) {
            $anggota = $this->anggotaRepository->findAnggotaByEmail($request->e);
            $data = [
                AbsensiPosyandu::POSYANDU_ID => $request->p,
                AbsensiPosyandu::LANSIA_ID   => $anggota->id,
                AbsensiPosyandu::MASUK => date('Y-m-d h:i:s')
            ];
        }else{
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! anggota not found"]);
        }
    }

    public function absensi_anggota_pulang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" =>  "required|email",
            'posyandu'  => "required",
        ]);
        if ($request->e =="" && $request->p=="") {
            return response()->json(["validation_errors" => $validator->errors()]);
        }

        $existsUser = $this->userRepository->findUserByEmailAndPosyandu($request->e, $request->p);
        if (!is_null($existsUser)) {
            $anggota = $this->anggotaRepository->findAnggotaByEmail($request->e);
            $data = [
                AbsensiPosyandu::POSYANDU_ID => $request->p,
                AbsensiPosyandu::LANSIA_ID   => $anggota->id,
                AbsensiPosyandu::PULANG => date('Y-m-d h:i:s'),
            ];
        }else{
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! anggota not found"]);
        }
    }
}
