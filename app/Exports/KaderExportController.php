<?php
    namespace App\Exports;

use App\Models\KaderPosyandu;
use App\Models\MstPosyandu;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KaderExportController implements FromCollection, WithHeadings
{
    use Exportable;

    public function headings():array
    {
        return ["POSYANDU KODE", "KADER KODE", "KADER NAMA", "KADER NIK", "KADER KK", "KADER ALAMAT", "KADER TELP"];
    }

    public function collection()
    {
        return KaderPosyandu::select(KaderPosyandu::POSYANDU_ID, KaderPosyandu::KADER_KODE, KaderPosyandu::KADER_NAMA,
        KaderPosyandu::KADER_NIK, KaderPosyandu::KADER_KK, KaderPosyandu::KADER_ALAMAT, KaderPosyandu::KADER_TELP)
         ->get()->take(2);
    }
}
