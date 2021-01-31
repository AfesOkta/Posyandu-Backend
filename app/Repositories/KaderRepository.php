<?php
namespace App\Repositories;

use App\Models\KaderPosyandu;

class KaderRepository
{
    protected $kaderPosyandu;
    public function __construct(KaderPosyandu $kaderPosyandu)
    {
        $this->kaderPosyandu = $kaderPosyandu;
    }

    public function getAll() {
        return $this->kaderPosyandu->all();
    }

    public function findFirst($id)
    {
        return $this->kaderPosyandu->find($id);
    }

    public function findByColumn($column, $value)
    {
        return $this->kaderPosyandu->where($column, $value)->get();
    }

    public function create($validateData)
    {
        $data = [
            KaderPosyandu::POSYANDU_ID => $validateData['posyandu_id'],
            KaderPosyandu::KADER_KODE => $validateData['kader_kode'],
            KaderPosyandu::KADER_NAMA => $validateData['kader_nama'],
            KaderPosyandu::KADER_ALAMAT => $validateData['kader_alamat'],
            KaderPosyandu::KADER_NIK => $validateData['kader_nik'],
            KaderPosyandu::KADER_TELP => $validateData['kader_telp'],
            KaderPosyandu::KADER_KK => $validateData['kader_kk'],
        ];
        return $this->kaderPosyandu->create($data);
    }
}
