<?php
namespace App\Repositories;

use App\Models\AbsensiPosyandu;

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
        return $this->absensiPosyandu->query()
            ->where('lansia_id','=', $lansiaId)
            ->where('posyandu_kode','=',$posyandu)
            ->where('status','=',$status)->first();
    }

    public function findAll() {
        return $this->absensiPosyandu->all();
    }
}
