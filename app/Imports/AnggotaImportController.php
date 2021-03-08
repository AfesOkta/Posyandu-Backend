<?php
    namespace App\Imports;

use App\Models\LansiaPosyandu;
use App\Models\MstPosyandu;
use App\Repositories\AnggotaRepository;
use App\Repositories\PosyanduRepository;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AnggotaImportController implements ToModel, WithValidation, SkipsOnFailure, WithHeadingRow, WithChunkReading
{
    use Importable, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $anggotaRepo = new AnggotaRepository(new LansiaPosyandu());
        $existsKode = $anggotaRepo->findByColumn(['lansia_kode','posyandu_kode'],[$row['anggota_kode'],$row['posyandu_kode']]);
        if ($existsKode->count() == 0) {
            $data = [
                LansiaPosyandu::POSYANDU_KODE   => $row['posyandu_kode'],
                LansiaPosyandu::LANSIA_KODE     => $row['anggota_kode'],
                LansiaPosyandu::LANSIA_NAMA     => $row['anggota_nama'],
                LansiaPosyandu::NAMA_IBU        => $row['nama_ibu'],
                LansiaPosyandu::NAMA_BAPAK      => $row['nama_bapak'],
                LansiaPosyandu::LANSIA_NIK      => $row['anggota_nik'],
                LansiaPosyandu::LANSIA_KK       => $row['anggota_kk'],
                LansiaPosyandu::LANSIA_ALAMAT   => $row['anggota_alamat'],
                LansiaPosyandu::LANSIA_TELP     => $row['anggota_telp'],
                LansiaPosyandu::EMAIL           => $row['email'],
            ];
            $anggotaRepo->create($data);
        }else{
            return session()->flash('error', 'Anggota Data unsuccessfully added, posyandu already exists.');
        }
    }

    public function rules(): array
    {
        return [
            'posyandu_kode' => 'required',
            'anggota_kode' => 'required',
            'anggota_nama' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'posyandu_kode.required' => 'Kode Posyandu tidak boleh kosong',
            'anggota_kode.required' => 'Kode Anggota tidak boleh kosong',
            'anggota_nama.required' => 'Nama Anggota tidak boleh kosong',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
