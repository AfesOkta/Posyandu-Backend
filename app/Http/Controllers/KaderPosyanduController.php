<?php

namespace App\Http\Controllers;

use App\Models\KaderPosyandu;
use App\Repositories\KaderRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KaderPosyanduController extends Controller
{
    protected $kaderRepository;
    public function __construct(KaderRepository $kaderRepository)
    {
        $this->middleware('auth');
        $this->kaderRepository = $kaderRepository;
    }

    public function json_list()
    {
        $data = $this->kaderRepository->getAll();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                return '<a href="javascript:void(0)" onclick="edit('.$row->id.')"
                    title="Edit '.$row->kader_nama.'" class="btn btn-info btn-sm btn-icon" data-dismiss="modal"><i class="fas fa-edit">&nbsp;edit</i></a>
                    <a href="javascript:void(0)" onclick="delete('.$row->id.')"
                    title="Delete '.$row->kader_nama.'" class="btn btn-danger btn-sm btn-icon" data-dismiss="modal"><i class="fas fa-trash">&nbsp;delete</i></a>
                             <meta name="csrf-token" content="{{ csrf_token() }}">';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('kader.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KaderPosyandu  $kaderPosyandu
     * @return \Illuminate\Http\Response
     */
    public function show(KaderPosyandu $kaderPosyandu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KaderPosyandu  $kaderPosyandu
     * @return \Illuminate\Http\Response
     */
    public function edit(KaderPosyandu $kaderPosyandu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KaderPosyandu  $kaderPosyandu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KaderPosyandu $kaderPosyandu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KaderPosyandu  $kaderPosyandu
     * @return \Illuminate\Http\Response
     */
    public function destroy(KaderPosyandu $kaderPosyandu)
    {
        //
    }
}
