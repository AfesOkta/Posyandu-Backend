<?php

namespace App\Http\Controllers;

use App\Repositories\AbsensiRepository;
use App\Repositories\PosyanduRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JsonController extends Controller
{
    //
    protected $posyanduRepo;
    protected $absenRepo;
    protected $userRepo;
    public function __construct(PosyanduRepository $posyanduRepo, AbsensiRepository $absenRepo, UserRepository $userRepo) {
        $this->posyanduRepo = $posyanduRepo;
        $this->absenRepo = $absenRepo;
        $this->userRepo = $userRepo;
    }

    public function posyandu()
    {
        # code...
        return response()->json($this->posyanduRepo->getAll());
    }

    private function json_absensi($status)
    {
        # code...
        $data = $this->absenRepo->findByStatus2($status);
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

    public function json_absensi_kader(Request $request)
    {
        # code...
        return $this->json_absensi(1);
    }

    public function json_absensi_anggota(Request $request)
    {
        # code...
        return $this->json_absensi(0);
    }

    public function json_users(Request $request)
    {
        # code...
        $data = $this->userRepo->findAll();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            return '<a href="javascript:void(0)" onclick="view('.$row->id.')"
                title="View '.$row->posyandu_nama.'" class="btn btn-info btn-sm btn-icon" data-dismiss="modal"><i class="fas fa-search">&nbsp;View</i></a>
                <meta name="csrf-token" content="{{ csrf_token() }}">';
        })
        ->rawColumns(['anggota','action'])
        ->make(true);
    }
}
