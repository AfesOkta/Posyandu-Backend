<?php
namespace App\Repositories;

use App\Models\AbsensiPosyandu;
use Illuminate\Support\Facades\DB;

class AbsensiRepository
{
    protected $absensiPosyandu;

    public function __construct(AbsensiPosyandu $absensiPosyandu) {
        $this->absensiPosyandu = $absensiPosyandu;
    }

    public function create($data)
    {
        return $this->absensiPosyandu->create($data);
    }

    public function update($data, $id)
    {
        return $this->absensiPosyandu->find($id)->update($data);
    }

    public function findAbsensiMasukAnggota($lansiaId, $posyandu, $status)
    {
        # code...
        $data =  $this->absensiPosyandu->query()
            ->where('lansia_id','=', $lansiaId)
            ->where('posyandu_kode','=',$posyandu)
            ->where('status','=',$status)
            ->where(DB::raw('date_format(masuk,"%Y-%m-%d")'), DB::raw('date_format(now(),"%Y-%m-%d")'))->first();
            return $data;
    }

    public function findAbsensiAnggota($lansiaId, $posyandu)
    {
        # code...
        $data =  $this->absensiPosyandu->query()
            ->where('lansia_id','=', $lansiaId)
            ->where('posyandu_kode','=',$posyandu)
            ->where(DB::raw('date_format(masuk,"%Y-%m-%d")'), DB::raw('date_format(now(),"%Y-%m-%d")'))->first();
            return $data;
    }

    public function findAll() {
        $data = DB::table('v_absensi')->orderBy('tanggal','desc')->get();
        return $data;//$this->absensiPosyandu->with('posyandu')->with('anggota')->get();
    }

    public function findByStatus2($status) {
        $data = DB::table('v_absensi')->where('status2',$status)->orderBy('posyandu_kode','asc')
        ->orderBy('kode','asc')->orderBy('tanggal','desc');
        return $data;//$this->absensiPosyandu->with('posyandu')->with('anggota')->get();
    }

    public function getCetakAbsen($posyandu, $tgl1, $tgl2, $status)
    {
        # code...
        $data = DB::table('v_absensi')
            ->where('posyandu_kode','=',$posyandu)
            ->whereBetween(DB::raw('date_format(tanggal,"%Y-%m-%d")'), ["$tgl1", "$tgl2"])
            ->where('status2',$status)
            ->groupBy('nama')
            ->groupBy('tanggal')
            ->orderBy('posyandu_kode','asc')
            ->orderBy('kode','asc')->orderBy('tanggal','desc')->get();
        return $data;
    }

    public function getViewAbsen($posyandu, $kode)
    {
        # code...
        $data = DB::table('v_absensi')
            ->where('posyandu_kode','=',$posyandu)
            ->where('kode',$kode)
            ->orderBy('tanggal')->get();
        return $data;
    }

}
