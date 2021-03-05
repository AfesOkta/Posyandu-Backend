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
            ->where(DB::raw('date_format(masuk,"%Y-%m-%d")'), DB::raw('date_format(Date_Sub(now(), INTERVAL 1 DAY),"%Y-%m-%d")'))->first();
            return $data;
    }

    public function findAll() {
        return $this->absensiPosyandu->with('posyandu')->with('anggota')->get();
    }
}
