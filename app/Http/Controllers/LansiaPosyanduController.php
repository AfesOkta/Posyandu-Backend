<?php

namespace App\Http\Controllers;

use App\Exports\AnggotaExportController;
use App\Http\Requests\LansiaRequest;
use App\Imports\AnggotaImportController;
use App\Models\User;
use App\Repositories\AnggotaRepository;
use App\Repositories\PosyanduRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Session;

class LansiaPosyanduController extends Controller
{
    //
    protected $lansiaRepository;
    protected $posyanduRepo;
    public function __construct(AnggotaRepository $lansiaRepository, PosyanduRepository $posyanduRepo)
    {
        $this->middleware('auth');
        $this->lansiaRepository = $lansiaRepository;
        $this->posyanduRepo = $posyanduRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posyandus = $this->posyanduRepo->getAll();
        return view('anggota.list', compact('posyandus'));
    }

    public function json_list() {
        $data = $this->lansiaRepository->getAll();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                return '<a href="javascript:void(0)" onclick="edit('.$row->id.')"
                    title="Edit '.$row->lansia_nama.'" class="btn btn-info btn-sm btn-icon" data-dismiss="modal"><i class="fas fa-edit">&nbsp;edit</i></a>
                    <a href="javascript:void(0)" onclick="generate_code('.$row->id.')"
                    title="Generated QR-Code '.$row->lansia_nama.'" class="btn btn-primary btn-sm btn-icon"><i class="fas fa-barcode">&nbsp;Qr-Code</i></a>
                    <a href="javascript:void(0)" onclick="hapus('.$row->id.')"
                    title="Delete '.$row->lansia_nama.'" class="btn btn-danger btn-sm btn-icon" data-dismiss="modal"><i class="fas fa-trash">&nbsp;delete</i></a>
                             <meta name="csrf-token" content="{{ csrf_token() }}">';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LansiaRequest $request)
    {
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $data = $request->all();
            $this->lansiaRepository->create($data);
            //Insert Users
            $data_user = [
                'email'     => $data['email'],
                'name'      => $data['lansia_nama'],
                'password'  => Hash::make("password"),
                'posyandu_kode' => $data['posyandu_kode'],
            ];
            $user   =   User::create($data_user);
            DB::commit();
            $message = "Tambah data anggota berhasil disimpan";
            $status  = True;
        }catch(Exception $ex) {
            Log::debug($ex->getMessage());
            DB::rollback();
            $message = "Tambah data anggota tidak berhasil disimpan";
            $status  = False;
        }

        return response()->json(["status" => $status, "message" => $message]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KaderPosyandu  $kaderPosyandu
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $kader = $this->lansiaRepository->findFirst($id);
        return response()->json($kader);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KaderPosyandu  $kaderPosyandu
     * @return \Illuminate\Http\Response
     */
    public function update(LansiaRequest $request)
    {
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $dataAll = $request->all();
            $this->lansiaRepository->update($dataAll);
            DB::commit();
            $message = "update data anggota berhasil disimpan";
            $status  = True;
        }catch(Exception $ex) {
            Log::debug($ex->getMessage());
            DB::rollback();
            $message = "Update data anggota tidak berhasil disimpan";
            $status  = False;
        }

        return response()->json(["status" => $status, "message" => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KaderPosyandu  $kaderPosyandu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        try{
            DB::beginTransaction();
            $delete = $this->lansiaRepository->findFirst($request->id)->delete();
            if ($delete) {
                $message = "Data anggota posyandu berhasil dihapus";
                $status  = True;
            }else{
                $message = "Data anggota posyandu tidak berhasil dihapus";
                $status  = False;
            }
            DB::commit();
        }catch(Exception $ex) {
            DB::rollBack();
            $message = "Data anggota posyandu tidak ditemukan";
            $status  = false;
        }

        return response()->json(["status" => $status, "message" => $message]);
    }

    public function qr_code($id)
    {
        # code...
        $lansia = $this->lansiaRepository->findFirst($id);
        $fileDest = 'img/qr-code/img-'.$lansia->id.'.png';
        $qrcode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)
                  ->generate("{{url('api/login?n='.$lansia->nik.'&p='.$lansia->posyandu_kode.')}}",
                  storage_path('app/'.$fileDest));

        Storage::disk('local')->put($fileDest, $qrcode);

        $url = base64_encode("{'n':".$lansia->nik.",'p':".$lansia->posyandu_kode."}");

        $url_down = url(storage_path("app/'+.$fileDest+"));
//pemdes-gelangkulon.com/api/v1/absensi?n,p,ps,0
        return view("anggota.qrcode",compact('url','url_down','fileDest'));
    }

    public function download()
    {
        # code...
        return Excel::download(new AnggotaExportController(), 'anggota.xlsx');
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
            $import = Excel::import(new AnggotaImportController(), public_path('/uploads/file/'.$nama_file));
            //unlink(public_path('uploads/bku/' . $nama_file)); //MENGHAPUS FILE EXCEL YANG TELAH DI-UPLOAD
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            foreach ($failures as $failure) {
                $message = $failure->values(); // The values of the row that has failed.
            }
        }
        // dd($import);
        // notifikasi dengan session
        Session::flash('succses','Anggota success import data!');

        // alihkan halaman kembali
        return redirect(route('anggota'))->with('Success','Import Anggota berhasil!');
    }

}
