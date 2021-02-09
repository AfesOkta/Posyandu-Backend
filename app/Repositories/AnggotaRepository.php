<?php
namespace App\Repositories;

use App\Models\LansiaPosyandu;
use Illuminate\Support\Facades\Auth;

class AnggotaRepository
{
    protected $lansiaPosyandu;
    protected $posyanduRepo;
    public function __construct(LansiaPosyandu $lansiaPosyandu)
    {
        $this->lansiaPosyandu = $lansiaPosyandu;
    }

    public function getAll() {
        return $this->lansiaPosyandu->with('posyandu')->get();
    }

    public function findAnggotaByEmail($email)
    {
        return $this->lansiaPosyandu->where('email','=',$email)->first();
    }

    public function findFirst($id)
    {
        return $this->lansiaPosyandu->find($id);
    }

    public function findByColumn($column, $value)
    {
        return $this->lansiaPosyandu->where($column, $value)->get();
    }

    public function create($validateData)
    {
        $data = [
            LansiaPosyandu::POSYANDU_ID => $validateData['posyandu_id'],
            LansiaPosyandu::LANSIA_KODE => $validateData['lansia_kode'],
            LansiaPosyandu::LANSIA_NAMA => $validateData['lansia_nama'],
            LansiaPosyandu::LANSIA_ALAMAT => $validateData['lansia_alamat'],
            LansiaPosyandu::LANSIA_NIK => $validateData['lansia_nik'],
            LansiaPosyandu::LANSIA_TELP => $validateData['lansia_telp'],
            LansiaPosyandu::LANSIA_KK => $validateData['lansia_kk'],
            LansiaPosyandu::USER_ID => Auth::user()->id,
            LansiaPosyandu::EMAIL   => $validateData['email'],
        ];
        return $this->lansiaPosyandu->create($data);
    }

    public function update($validateData)
    {
        $data = [
            LansiaPosyandu::POSYANDU_ID => $validateData['posyandu_id'],
            LansiaPosyandu::LANSIA_KODE => $validateData['lansia_kode'],
            LansiaPosyandu::LANSIA_NAMA => $validateData['lansia_nama'],
            LansiaPosyandu::LANSIA_ALAMAT => $validateData['lansia_alamat'],
            LansiaPosyandu::LANSIA_NIK => $validateData['lansia_nik'],
            LansiaPosyandu::LANSIA_TELP => $validateData['lansia_telp'],
            LansiaPosyandu::LANSIA_KK => $validateData['lansia_kk'],
            LansiaPosyandu::USER_ID => Auth::user()->id,
            LansiaPosyandu::EMAIL   => $validateData['email'],
        ];

        return $this->lansiaPosyandu->find($validateData['lansia_id'])->update($data);
    }

}
