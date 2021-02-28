<?php
    namespace App\Exports;

use App\Models\MstPosyandu;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PosyanduExportController implements WithHeadings, FromCollection
{
    use Exportable;

    public function headings():array
    {
        return ["KODE", "NAMA"];
    }

    public function collection()
    {
        return MstPosyandu::select('posyandu_kode', 'posyandu_nama')
         ->get()->take(2);
    }
}
