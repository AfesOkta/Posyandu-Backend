<?php

namespace App\Http\Controllers;

use App\Exports\PosyanduExportController;
use App\Http\Requests\PosyanduRequest;
use App\Imports\PosyanduImportController;
use App\Models\MstPosyandu;
use App\Repositories\PosyanduRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
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
                    title="Edit '.$row->posyandu_nama.'" class="btn btn-info btn-sm btn-icon" data-dismiss="modal"><i class="fas fa-edit">&nbsp;edit</i></a>
                    <a href="javascript:void(0)" onclick="hapus('.$row->id.')"
                    title="Delete '.$row->posyandu_nama.'" class="btn btn-danger btn-sm btn-icon" data-dismiss="modal"><i class="fas fa-trash">&nbsp;delete</i></a>
                             <meta name="csrf-token" content="{{ csrf_token() }}">';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function json_select()
    {
        $data = $this->posyanduRepo->getAll();
        return response()->json($data);
    }

    public function store(PosyanduRequest $request)
    {
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $data = $request->all();
            $this->posyanduRepo->create($data);
            DB::commit();
            $message = "Tambah data posyandu berhasil disimpan";
            $status  = True;
        }catch(Exception $ex) {
            Log::debug($ex->getMessage());
            DB::rollback();
            $message = "Tambah data posyandu tidak berhasil disimpan";
            $status  = False;
        }

        return response()->json(["status" => $status, "message" => $message]);
    }

    public function update(PosyanduRequest $request)
    {
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $dataAll = $request->all();
            $data = [
                MstPosyandu::POSYANDU_KODE => $dataAll['posyandu_kode'],
                MstPosyandu::POSYANDU_NAMA => $dataAll['posyandu_nama']
            ];
            $this->posyanduRepo->findFirst($dataAll['posyandu_id'])->update($data);
            DB::commit();
            $message = "update data posyandu berhasil disimpan";
            $status  = True;
        }catch(Exception $ex) {
            Log::debug($ex->getMessage());
            DB::rollback();
            $message = "Update data posyandu tidak berhasil disimpan";
            $status  = False;
        }

        return response()->json(["status" => $status, "message" => $message]);
    }

    public function getPosyandu(Request $request)
    {
        $data = $this->posyanduRepo->findFirst($request->id);
        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        # code...
        try{
            DB::beginTransaction();
            $delete = $this->posyanduRepo->findFirst($request->id)->delete();
            if ($delete) {
                $message = "Data posyandu berhasil dihapus";
                $status  = True;
            }else{
                $message = "Data posyandu tidak berhasil dihapus";
                $status  = False;
            }
            DB::commit();
        }catch(Exception $ex) {
            DB::rollBack();
            $message = "Data posyandu tidak ditemukan";
            $status  = false;
        }

        return response()->json(["status" => $status, "message" => $message]);
    }

    public function download()
    {
        # code...
        return Excel::download(new PosyanduExportController(), 'posyandu.xlsx');
    }

    public function import(Request $request)
    {
        # code...
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $err_msg_array = array();

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand().$file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('uploads/file',$nama_file);

        // import data
        try {
            $import = Excel::import(new PosyanduImportController(), public_path('/uploads/file/'.$nama_file));
            //unlink(public_path('uploads/bku/' . $nama_file)); //MENGHAPUS FILE EXCEL YANG TELAH DI-UPLOAD
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            foreach ($failures as $failure) {
                $message = $failure->values(); // The values of the row that has failed.
            }
        }
        // dd($import);
        // notifikasi dengan session
        Session::flash('succses','Posyandu success import data!');

        // alihkan halaman kembali
        return redirect(route('posyandu'))->with('Success','Import posyandu berhasil!');
    }
}
