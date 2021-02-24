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
            $anggota = $this->lansiaRepository->findAnggotaByNikAndPosyandu($request->n,$request->p);
            if(!is_null($anggota)) {
                $data = [
                    AbsensiPosyandu::POSYANDU_ID => $request->p,
                    AbsensiPosyandu::LANSIA_ID   => $anggota->id,
                    AbsensiPosyandu::MASUK       => date('Y-m-d h:i:s'),
                    AbsensiPosyandu::STATUS      => 0,
                ];
                $store = $this->absensiRepository->create($data);
                if ($store) {
                    return response()->json(["status" => "success", "success" => true, "message" => "anggota berhasil absensi masuk"]);
                }else{
                    return response()->json(["status" => "failed", "success" => false, "message" => "anggota tidak berhasil absensi masuk"]);
                }
            }

            $kader = $this->kaderRepository->findAnggotaByNikAndPosyandu($request->n,$request->p);
            if(!is_null($kader)) {
                $data = [
                    AbsensiPosyandu::POSYANDU_ID    => $request->p,
                    AbsensiPosyandu::KADER_ID       => $kader->id,
                    AbsensiPosyandu::MASUK          => date('Y-m-d h:i:s'),
                    AbsensiPosyandu::STATUS         => 0,
                ];
                $store = $this->absensiRepository->create($data);
                if ($store) {
                    return response()->json(["status" => "success", "success" => true, "message" => "Kader berhasil absensi masuk"]);
                }else{
                    return response()->json(["status" => "failed", "success" => false, "message" => "Kader tidak berhasil absensi masuk"]);
                }
            }

            if (is_null($anggota) && is_null($kader)) {
                return response()->json(["status" => "failed", "success" => false, "message" => "Tidak berhasil absensi masuk"]);
            }
        }

    }

    public function absensi_pulang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nik" =>  "required",
            'posyandu'  => "required",
        ]);
        if ($request->n =="" && $request->p=="" && $request->ps == "") {
            return response()->json(["validation_errors" => $validator->errors()]);
        }
        if ($request->p != $request->ps) {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! anggota not found"]);
        } else {
            $anggota = $this->lansiaRepository->findAnggotaByNikAndPosyandu($request->n,$request->p);
            if(!is_null($anggota)) {
                $existsAbsensi = $this->absensiRepository->findAbsensiMasukAnggota($anggota->id, $request->p, 0);
                if (!is_null($existsAbsensi)) {
                    $data = [
                        AbsensiPosyandu::POSYANDU_ID => $request->p,
                        AbsensiPosyandu::LANSIA_ID   => $anggota->id,
                        AbsensiPosyandu::PULANG       => date('Y-m-d h:i:s'),
                        AbsensiPosyandu::STATUS         => 1,
                    ];
                    $store = $this->absensiRepository->update($data, $existsAbsensi->id);
                    if ($store) {
                        return response()->json(["status" => "success", "success" => true, "message" => "anggota berhasil absensi pulang"]);
                    }else{
                        return response()->json(["status" => "failed", "success" => false, "message" => "anggota tidak berhasil absensi pulang"]);
                    }
                }else{
                    return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! anggota not found"]);
                }
            }

            $kader = $this->kaderRepository->findAnggotaByNikAndPosyandu($request->n,$request->p);
            if(!is_null($kader)) {
                $existsAbsensi = $this->absensiRepository->findAbsensiMasukAnggota($kader->id, $request->p, 0);
                if (!is_null($existsAbsensi)) {
                    $data = [
                        AbsensiPosyandu::POSYANDU_ID    => $request->p,
                        AbsensiPosyandu::KADER_ID       => $kader->id,
                        AbsensiPosyandu::PULANG         => date('Y-m-d h:i:s'),
                        AbsensiPosyandu::STATUS         => 1,
                    ];
                    $store = $this->absensiRepository->update($data, $existsAbsensi->id);
                    if ($store) {
                        return response()->json(["status" => "success", "success" => true, "message" => "Kader berhasil absensi pulang"]);
                    }else{
                        return response()->json(["status" => "failed", "success" => false, "message" => "Kader tidak berhasil absensi pulang"]);
                    }
                }else{
                    return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! kader not found"]);
                }
            }

            if (is_null($anggota) && is_null($kader)) {
                return response()->json(["status" => "failed", "success" => false, "message" => "Tidak berhasil absensi pulang"]);
            }
        }
    }

    public function index(Request $request)
    {
        # code...
        return view('absensi.list');
    }

    public function json(Request $request)
    {
        $data = $this->absensiRepository->findAll();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            return '<a href="javascript:void(0)" onclick="view('.$row->id.')"
                title="View '.$row->posyandu_nama.'" class="btn btn-info btn-sm btn-icon" data-dismiss="modal"><i class="fas fa-search">&nbsp;View</i></a>
                <meta name="csrf-token" content="{{ csrf_token() }}">';
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}
