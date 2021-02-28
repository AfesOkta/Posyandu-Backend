<?php
    namespace App\Exports;

use App\Models\LansiaPosyandu;
use App\Models\MstPosyandu;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnggotaExportController implements WithHeadings, FromCollection
{
    use Exportable;

    public function headings():array
    {
        return ["POSYANDU KODE", "ANGGOTA KODE", "ANGGOTA NAMA", "NAMA IBU", "NAMA BAPAK", "ANGGOTA NIK", "ANGGOTA KK", "ANGGOTA ALAMAT", "ANGGOTA TELP", "EMAIL"];
    }

    public function collection()
    {
        return LansiaPosyandu::select(LansiaPosyandu::POSYANDU_KODE, LansiaPosyandu::LANSIA_KODE, LansiaPosyandu::LANSIA_NAMA, LansiaPosyandu::NAMA_IBU, LansiaPosyandu::NAMA_BAPAK,
        LansiaPosyandu::LANSIA_NIK, LansiaPosyandu::LANSIA_KK, LansiaPosyandu::LANSIA_ALAMAT, LansiaPosyandu::LANSIA_TELP, LansiaPosyandu::EMAIL)
         ->get()->take(2);
    }
}
