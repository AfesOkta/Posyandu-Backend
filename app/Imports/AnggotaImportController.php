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
        $existsKode = $anggotaRepo->findByColumn(['lansia_kode','posyandu_kode'],[$row['kode'],$row['kode']]);
        if ($existsKode->count() == 0) {
            $data = [
                LansiaPosyandu::POSYANDU_KODE   => $row['POSYANDU KODE'],
                LansiaPosyandu::LANSIA_KODE     => $row['ANGGOTA KODE'],
                LansiaPosyandu::LANSIA_NAMA     => $row['ANGGOTA NAMA'],
                LansiaPosyandu::NAMA_IBU        => $row['NAMA IBU'],
                LansiaPosyandu::NAMA_BAPAK      => $row['NAMA BAPAK'],
                LansiaPosyandu::LANSIA_NIK      => $row['ANGGOTA NIK'],
                LansiaPosyandu::LANSIA_KK       => $row['ANGGOTA KK'],
                LansiaPosyandu::LANSIA_ALAMAT   => $row['ANGGOTA ALAMAT'],
                LansiaPosyandu::LANSIA_TELP     => $row['ANGGOTA TELP'],
                LansiaPosyandu::EMAIL           => $row['EMAIL'],
            ];
            $anggotaRepo->create($data);
        }else{
            return session()->flash('error', 'Anggota Data unsuccessfully added, posyandu already exists.');
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
