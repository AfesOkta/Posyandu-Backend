<?php
    namespace App\Imports;

use App\Models\MstPosyandu;
use App\Repositories\PosyanduRepository;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PosyanduImportController implements ToModel, WithValidation, SkipsOnFailure, WithHeadingRow, WithChunkReading
{
    use Importable, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $posyanduRepo = new PosyanduRepository(new MstPosyandu());
        $existsKode = $posyanduRepo->findByColumn('posyandu_kode',$row['kode']);
        if ($existsKode == null ) {
            $data = [
                MstPosyandu::POSYANDU_KODE => $row['kode'],
                MstPosyandu::POSYANDU_NAMA => $row['nama'],
            ];
            $posyanduRepo->create($data);
        }else{
            return session()->flash('error', 'Posyandu Data unsuccessfully added, posyandu already exists.');
        }
    }

    public function rules(): array
    {
        return [
            'kode' => 'required',
            'nama' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'kode.required' => 'Kode Posyandu tidak boleh kosong',
            'nama.required' => 'Nama Posyandu tidak boleh kosong',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
