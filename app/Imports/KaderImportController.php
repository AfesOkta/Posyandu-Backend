<?php
    namespace App\Imports;

use App\Models\KaderPosyandu;
use App\Models\LansiaPosyandu;
use App\Models\MstPosyandu;
use App\Repositories\AnggotaRepository;
use App\Repositories\KaderRepository;
use App\Repositories\PosyanduRepository;
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
        $existsKode = $kaderRepo->findByColumn(['lansia_kode','posyandu_kode'],[$row['kode'],$row['kode']]);
        if ($existsKode->count() == 0) {
            $data = [
                KaderPosyandu::POSYANDU_ID    => $row['POSYANDU KODE'],
                KaderPosyandu::KADER_KODE     => $row['KADER KODE'],
                KaderPosyandu::KADER_NAMA     => $row['KADER NAMA'],
                KaderPosyandu::KADER_NIK      => $row['KADER NIK'],
                KaderPosyandu::KADER_KK       => $row['KADER KK'],
                KaderPosyandu::KADER_ALAMAT   => $row['KADER ALAMAT'],
                KaderPosyandu::KADER_TELP     => $row['KADER TELP'],
            ];
            $kaderRepo->create($data);
        }else{
            return session()->flash('error', 'Kader Data unsuccessfully added, kader already exists.');
        }
    }

    public function rules(): array
    {
        return [
            'POSYANDU KODE' => 'required',
            'ANGGOTA KODE' => 'required',
            'ANGGOTA NAMA' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '0.required' => 'Kode Posyandu tidak boleh kosong',
            '1.required' => 'Kode Anggota tidak boleh kosong',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
