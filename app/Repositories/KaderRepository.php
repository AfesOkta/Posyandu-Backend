<?php
namespace App\Repositories;

use App\Models\KaderPosyandu;
use Illuminate\Support\Facades\Auth;

class KaderRepository
{
    protected $kaderPosyandu;
    public function __construct(KaderPosyandu $kaderPosyandu)
    {
        $this->kaderPosyandu = $kaderPosyandu;
    }

    public function getAll() {
        return $this->kaderPosyandu->with('posyandu')->get();
    }

    public function findFirst($id)
    {
        return $this->kaderPosyandu->find($id);
    }

    public function findByColumn($column, $value)
    {
        // return $this->kaderPosyandu->where($column, $value)->get();
        $count = is_array($column) ? count($column) : 0;
        $kader = $this->kaderPosyandu;
        if ($count != 0) {
            for ($i=0; $i < $count; $i++) {
                $kader->where($column[$i], $value[$i]);
            }
        } else {
            $kader->where($column, $value);
        }
        return $kader->first();
    }

    public function findByKaderAndPosyandu($kader, $posyandu)
    {
        # code...
        return $this->kaderPosyandu->where('kader_kode','=', $kader)->where('posyandu_kode','=', $posyandu)->first();
    }

    public function findAnggotaByNikAndPosyandu($nik, $posyandu)
    {
        # code...
        return $this->kaderPosyandu->where('kader_nik','=', $nik)->where('posyandu_kode','=', $posyandu)->first();
    }
    public function create($validateData)
    {
        $data = [
            KaderPosyandu::POSYANDU_KODE => $validateData['posyandu_kode'],
            KaderPosyandu::KADER_KODE => $validateData['kader_kode'],
            KaderPosyandu::KADER_NAMA => $validateData['kader_nama'],
            KaderPosyandu::KADER_ALAMAT => $validateData['kader_alamat'],
            KaderPosyandu::KADER_NIK => $validateData['kader_nik'],
            KaderPosyandu::KADER_TELP => $validateData['kader_telp'],
            KaderPosyandu::KADER_KK => $validateData['kader_kk'],
            KaderPosyandu::USER_ID => Auth::user()->id
        ];
        return $this->kaderPosyandu->create($data);
    }

    public function update($validateData)
    {
        $data = [
            KaderPosyandu::POSYANDU_KODE => $validateData['posyandu_kode'],
            KaderPosyandu::KADER_KODE => $validateData['kader_kode'],
            KaderPosyandu::KADER_NAMA => $validateData['kader_nama'],
            KaderPosyandu::KADER_ALAMAT => $validateData['kader_alamat'],
            KaderPosyandu::KADER_NIK => $validateData['kader_nik'],
            KaderPosyandu::KADER_TELP => $validateData['kader_telp'],
            KaderPosyandu::KADER_KK => $validateData['kader_kk'],
            KaderPosyandu::USER_ID => Auth::user()->id
        ];

        return $this->kaderPosyandu->find($validateData['kader_id'])->update($data);
    }

    public function countPosyandu($posyandu_kode)
    {
        # code...
        return $this->kaderPosyandu->where('posyandu_kode', $posyandu_kode)->count();
    }
}
