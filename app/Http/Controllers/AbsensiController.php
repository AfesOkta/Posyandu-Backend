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
use App\Repositories\PosyanduRepository;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade as PDF;

class AbsensiController extends Controller
{
    //
    protected $userRepository;
    protected $lansiaRepository;
    protected $absensiRepository;
    protected $kaderRepository;
    protected $posyanduRepo;

    public function __construct(UserRepository $userRepository, AnggotaRepository $anggotaRepository, KaderRepository $kaderRepository,
        AbsensiRepository $absensiRepository,  PosyanduRepository $posyanduRepo) {
        $this->middleware('auth');
        $this->userRepository       = $userRepository;
        $this->lansiaRepository     = $anggotaRepository;
        $this->kaderRepository      = $kaderRepository;
        $this->absensiRepository    = $absensiRepository;
        $this->posyanduRepo         = $posyanduRepo;
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
                return response()->json(["status" => "failed", "success" => false, "message" => "Anda sudah melakukan absensi"]);
            }
        }

    }


    private function absensi_anggota(Request $request)
    {
        $anggota = false;
        $existsAnggota = $this->lansiaRepository->findAnggotaByNikAndPosyandu($request->n,$request->p);
        if(!is_null($existsAnggota)) {
            if ($request->s == 0) { //Masuk
                // $existsAbsensi = $this->absensiRepository->findAbsensiMasukAnggota($existsAnggota->id, $request->p, 0);
                // if (!is_null($existsAbsensi)) {
                //     $anggota = false;
                // } else {
                $existsAbsensi = $this->absensiRepository->findAbsensiAnggota($existsAnggota->id, $request->p);
                if (!is_null($existsAbsensi)) {
                    // $data = [
                    //     AbsensiPosyandu::MASUK       => date('Y-m-d h:i:s'),
                    //     AbsensiPosyandu::STATUS      => 0,
                    // ];
                    // $store = $this->absensiRepository->update($data, $existsAbsensi->id);
                    // if ($store) {
                    //     $anggota = true;
                    // }else{
                    //     $anggota = false;
                    // }
                    $anggota = false;
                } else {
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
                // }
            }else{
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
                } else {
                    $anggota = false;
                }
            }
        }
        return $anggota;
    }

    private function absensi_kader(Request $request)
    {
        $kader = false;
        $existsKader = $this->kaderRepository->findAnggotaByNikAndPosyandu($request->n,$request->p);
        if(!is_null($existsKader)) {
            $existsAbsensi = $this->absensiRepository->findAbsensiMasukAnggota($existsKader->id, $request->p, 1);
            if (!is_null($existsAbsensi)) {
                $kader = false;
            }else {
                $existsAbsensi = $this->absensiRepository->findAbsensiAnggota($existsKader->id, $request->p);
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
                        AbsensiPosyandu::LANSIA_ID      => $existsKader->id,
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
        $posyandus = $this->posyanduRepo->getAll();
        return view('absensi.list', compact('posyandus'));
    }

    private function cetak($tglAwal, $tglAkhir, $posyandu, $status, $fTglAwal, $fTglAkhir){
        $data = $this->absensiRepository->getCetakAbsen($posyandu, $tglAwal, $tglAkhir, $status);
        $data_posyandu = $this->posyanduRepo->findByColumn('posyandu_kode', $posyandu);
        $pdf = PDF::loadview('absensi.cetak',['datas'=>$data, 'data_posyandu' => $data_posyandu, 'tglAwal' => $fTglAwal, 'tglAkhir' => $fTglAkhir]);
        return $pdf->stream('absensi.pdf');
    }

    public function cetak_anggota($url){
        $urlDecode = explode('&',base64_decode($url));
        $tglAwal   = date("Y-m-d", strtotime($urlDecode[0]));
        $tglAkhir  = date("Y-m-d", strtotime($urlDecode[1]));
        $fTglAwal   = date("d-m-Y", strtotime($urlDecode[0]));
        $fTglAkhir  = date("d-m-Y", strtotime($urlDecode[1]));
        $posyandu  = $urlDecode[2];
        return $this->cetak($tglAwal, $tglAkhir, $posyandu, 0, $fTglAwal, $fTglAkhir);
    }

    public function cetak_kader($url){
        $urlDecode = explode('&',base64_decode($url));
        $tglAwal   = date("Y-m-d", strtotime($urlDecode[0]));
        $tglAkhir  = date("Y-m-d", strtotime($urlDecode[1]));
        $fTglAwal   = date("d-m-Y", strtotime($urlDecode[0]));
        $fTglAkhir  = date("d-m-Y", strtotime($urlDecode[1]));
        $posyandu  = $urlDecode[2];
        return $this->cetak($tglAwal, $tglAkhir, $posyandu, 1, $fTglAwal, $fTglAkhir);
    }

    public function view_anggota($url)
    {
        # code...
        $urlDecode = explode('&',base64_decode($url));
        $posyandu_kode = $urlDecode[0];
        $lansia_kode = $urlDecode[1];

        $posyandu = $this->posyanduRepo->findByColumn('posyandu_kode',$posyandu_kode);
        $lansia = $this->lansiaRepository->findByAnggotaAndPosyandu($lansia_kode, $posyandu_kode);

        $data = $this->absensiRepository->getViewAbsen($posyandu_kode, $lansia_kode);
        return view('absensi.view',['datas' => $data, 'posyandu' => $posyandu, 'lansia' => $lansia, 'status' => 0]);
    }

    public function view_kader($url)
    {
        # code...
        $urlDecode = explode('&',base64_decode($url));
        $posyandu_kode = $urlDecode[0];
        $kader_kode = $urlDecode[1];

        $posyandu = $this->posyanduRepo->findByColumn('posyandu_kode',$posyandu_kode);
        $kader = $this->kaderRepository->findByKaderAndPosyandu($kader_kode,$posyandu_kode);

        $data = $this->absensiRepository->getViewAbsen($posyandu_kode, $kader_kode);
        return view('absensi.view',['datas' => $data, 'posyandu' => $posyandu, 'kader' => $kader , 'status' => 1]);
    }
}
