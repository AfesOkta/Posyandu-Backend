<?php

namespace App\Http\Controllers;

use App\Repositories\AnggotaRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LansiaPosyanduController extends Controller
{
    //
    protected $lansiaRepository;
    public function __construct(AnggotaRepository $lansiaRepository)
    {
        $this->middleware('auth');
        $this->lansiaRepository = $lansiaRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('anggota.list');
    }

    public function json_list() {
        $data = $this->lansiaRepository->getAll();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                return '<a href="javascript:void(0)" onclick="edit('.$row->id.')"
                    title="Edit '.$row->lansia_nama.'" class="btn btn-info btn-sm btn-icon" data-dismiss="modal"><i class="fas fa-edit">&nbsp;edit</i></a>
                    <a href="javascript:void(0)" onclick="delete('.$row->id.')"
                    title="Delete '.$row->lansia_nama.'" class="btn btn-danger btn-sm btn-icon" data-dismiss="modal"><i class="fas fa-trash">&nbsp;delete</i></a>
                             <meta name="csrf-token" content="{{ csrf_token() }}">';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
