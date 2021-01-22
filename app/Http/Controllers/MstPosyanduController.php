<?php

namespace App\Http\Controllers;

use App\Repositories\PosyanduRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MstPosyanduController extends Controller
{
    //
    protected $posyanduRepo;
    public function __construct(PosyanduRepository $posyanduRepo)
    {
        $this->middleware('auth');
        $this->posyanduRepo = $posyanduRepo;
    }

    public function index(Request $request)
    {
        return view('posyandu.list');
    }

    public function json_list()
    {
        $data = $this->posyanduRepo->getAll();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                return '<a href="javascript:void(0)" onclick="edit('.$row->id.')"
                    title="Edit '.$row->posyandu_nama.'" class="btn btn-success btn-xs btn_skpd" data-dismiss="modal"><i class="material-icons">edit</i></a>
                    <a href="javascript:void(0)" onclick="delete('.$row->id.')"
                    title="Delete '.$row->posyandu_nama.'" class="btn btn-success btn-xs btn_skpd" data-dismiss="modal"><i class="material-icons">delete</i></a>
                             <meta name="csrf-token" content="{{ csrf_token() }}">';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
