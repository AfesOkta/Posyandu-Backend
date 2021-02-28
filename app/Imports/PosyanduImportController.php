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
        $existsKode = $posyanduRepo->findByColumn('posyandu_kode',$row['posyandu_kode']);
        if ($existsKode->count() == 0) {
            $data = [
                MstPosyandu::POSYANDU_KODE => $row['posyandu_kode'],
                MstPosyandu::POSYANDU_NAMA => $row['posyandu_kode'],
            ];
            $posyanduRepo->create($data);
        }
    }

    public function rules(): array
    {
        return [
            'posyandu_kode' => 'required',
            'posyandu_nama' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '0.required' => 'Kode Posyandu tidak boleh kosong',
            '1.required' => 'Nama Posyandu tidak boleh kosong',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
