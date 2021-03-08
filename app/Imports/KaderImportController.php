<?php
    namespace App\Imports;

use App\Models\KaderPosyandu;
use App\Models\LansiaPosyandu;
use App\Models\MstPosyandu;
use App\Models\User;
use App\Models\UsersPosyandu;
use App\Repositories\AnggotaRepository;
use App\Repositories\KaderRepository;
use App\Repositories\PosyanduRepository;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class KaderImportController implements ToModel, WithValidation, SkipsOnFailure, WithHeadingRow, WithChunkReading
{
    use Importable, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $kaderRepo = new KaderRepository(new KaderPosyandu());
        $existsKode = $kaderRepo->findByKaderAndPosyandu($row['kader_kode'],$row['posyandu_kode']);
        if ($existsKode == null) {
            $data = [
                KaderPosyandu::POSYANDU_KODE  => $row['posyandu_kode'],
                KaderPosyandu::KADER_KODE     => $row['kader_kode'],
                KaderPosyandu::KADER_NAMA     => $row['kader_nama'],
                KaderPosyandu::KADER_NIK      => $row['kader_nik'],
                KaderPosyandu::KADER_KK       => $row['kader_kk'],
                KaderPosyandu::KADER_ALAMAT   => $row['kader_alamat'],
                KaderPosyandu::KADER_TELP     => $row['kader_telp'],
            ];
            $kaderRepo->create($data);

            $dataUser = [
                "name"      =>  $row['kader_kode'],
                "email"     =>  $row['kader_kode'].'@pemdes-gelangkulon.com',
                "phone"     =>  $row['kader_telp'],
                "password"  =>  Hash::make("Sa123456"),
            ];

            $user   =   User::create($dataUser);

            $dataUserAkses = [
                "user_id"  => $row['kader_kode'],
                "posyandu_kode" => $row['posyandu_kode'],
            ];

            $userAkses = UsersPosyandu::create($dataUserAkses);

        }else{
            return session()->flash('error', 'Kader Data unsuccessfully added, kader already exists.');
        }
    }

    public function rules(): array
    {
        return [
            'posyandu_kode' => 'required',
            'kader_kode' => 'required',
            'kader_nama' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'posyandu_kode.required' => 'Kode Posyandu tidak boleh kosong',
            'kader_kode.required' => 'Kode Kader tidak boleh kosong',
            'kader_kode.required' => 'Kode Nama tidak boleh kosong',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
