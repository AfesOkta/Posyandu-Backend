<?php

namespace App\Http\Controllers;

use App\Models\AbsensiPosyandu;
use App\Models\LansiaPosyandu;
use App\Repositories\AbsensiRepository;
use App\Repositories\AnggotaRepository;
use App\Repositories\KaderRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AbsensiController extends Controller
{
    //
    protected $userRepository;
    protected $lansiaRepository;
    protected $absensiRepository;
    protected $kaderRepository;

    public function __construct(UserRepository $userRepository, AnggotaRepository $anggotaRepository, KaderRepository $kaderRepository,
        AbsensiRepository $absensiRepository) {
        $this->middleware('auth');
        $this->userRepository       = $userRepository;
        $this->lansiaRepository     = $anggotaRepository;
        $this->kaderRepository      = $kaderRepository;
        $this->absensiRepository    = $absensiRepository;
    }

    public function absensi_masuk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nik" =>  "required",
            'posyandu'  => "required",
        ]);
        if ($request->n =="" && $request->p=="" && $request->ps == "") {
            return response()->json(["validation_errors" => $validator->errors()]);
        }

        // $existsUser = $this->userRepository->findUserByEmailAndPosyandu($request->e, $request->p);
        // if (!is_null($existsUser)) {
        if ($request->p != $request->ps) {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! anggota not found"]);
        } else {
            $anggota = $this->absensi_anggota($request);

            $kader   = $this->absensi_kader($request);
            if ($anggota) {
                return response()->json(["status" => "success", "success" => true, "message" => "Anggota Berhasil absen"]);
            }else if($kader){
                return response()->json(["status" => "success", "success" => true, "message" => "Kader berhasil absen"]);
            }else if (!$anggota && !$kader) {
                return response()->json(["status" => "failed", "success" => false, "message" => "Tidak berhasil absen"]);
            }
        }

    }


    private function absensi_anggota(Request $request)
    {
        $anggota = false;
        $existsAnggota = $this->lansiaRepository->findAnggotaByNikAndPosyandu($request->n,$request->p);
        if(!is_null($existsAnggota)) {
            $existsAbsensi = $this->absensiRepository->findAbsensiMasukAnggota($existsAnggota->id, $request->p, 1);
            if (!is_null($existsAbsensi)) {
                $anggota = false;
            }else {
                $existsAbsensi = $this->absensiRepository->findAbsensiMasukAnggota($existsAnggota->id, $request->p, 0);
                if (!is_null($existsAbsensi)) {
                    $data = [
                        AbsensiPosyandu::PULANG       => date('Y-m-d h:i:s'),
                        AbsensiPosyandu::STATUS      => 1,
                    ];
                    $store = $this->absensiRepository->update($data, $existsAbsensi->id);
                    if ($store) {
                        $anggota = true;
                    }else{
                        $anggota = false;
                    }
                }else {
                    $data = [
                        AbsensiPosyandu::POSYANDU_ID => $request->p,
                        AbsensiPosyandu::LANSIA_ID   => $existsAnggota->id,
                        AbsensiPosyandu::MASUK       => date('Y-m-d h:i:s'),
                        AbsensiPosyandu::STATUS      => 0,
                        AbsensiPosyandu::STATUS2     => 0,
                    ];
                    $store = $this->absensiRepository->create($data);
                    if ($store) {
                        $anggota = true;
                    }else{
                        $anggota = false;
                    }
                }
            }
        }
        return $anggota;
    }

    private function absensi_kader(Request $request)
    {
        $kader = false;
        $existsKader = $this->kaderRepository->findAnggotaByNikAndPosyandu($request->n,$request->p);
        if(!is_null($kader)) {
            $existsAbsensi = $this->absensiRepository->findAbsensiMasukAnggota($existsKader->id, $request->p, 1);
            if (!is_null($existsAbsensi)) {
                $kader = false;
            }else {
                $existsAbsensi = $this->absensiRepository->findAbsensiMasukAnggota($existsKader->id, $request->p, 0);
                if (!is_null($existsAbsensi)) {
                    $data = [
                        AbsensiPosyandu::PULANG         => date('Y-m-d h:i:s'),
                        AbsensiPosyandu::STATUS         => 1,
                    ];
                    $store = $this->absensiRepository->update($data, $existsAbsensi->id);
                    if ($store) {
                        $kader = true;
                    }else{
                        $kader = false;
                    }
                }else{
                    $data = [
                        AbsensiPosyandu::POSYANDU_ID    => $request->p,
                        AbsensiPosyandu::KADER_ID       => $existsKader->id,
                        AbsensiPosyandu::MASUK          => date('Y-m-d h:i:s'),
                        AbsensiPosyandu::STATUS         => 0,
                        AbsensiPosyandu::STATUS2        => 1,
                    ];
                    $store = $this->absensiRepository->create($data);
                    if ($store) {
                        $kader = true;
                    }else{
                        $kader = false;
                    }
                }
            }
        }
        return $kader;
    }

    public function index()
    {
        # code...
        return view('absensi.list');
    }
}
