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

    public function json_absensi(Request $request)
    {
        # code...
        $data = $this->absenRepo->findAll();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('anggota', function($row){
            if($row->status2 == 0) {
                $content = $row->anggota->lansia_nama;
            }else{
                $content = $row->kader->kader_nama;
            }
            return $content;
        })
        ->addColumn('action', function($row){
            return '<a href="javascript:void(0)" onclick="view('.$row->id.')"
                title="View '.$row->posyandu_nama.'" class="btn btn-info btn-sm btn-icon" data-dismiss="modal"><i class="fas fa-search">&nbsp;View</i></a>
                <meta name="csrf-token" content="{{ csrf_token() }}">';
        })
        ->rawColumns(['anggota','action'])
        ->make(true);
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
