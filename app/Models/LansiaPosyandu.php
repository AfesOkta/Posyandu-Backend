<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LansiaPosyandu extends Model
{
    use HasFactory;
    const POSYANDU_ID   = 'posyandu_id';
    const LANSIA_KODE   = 'lansia_kode';
    const LANSIA_NIK    = 'lansia_nik';
    const LANSIA_KK     = 'lansia_kk';
    const LANSIA_ALAMAT = 'lansia_alamat';
    const LANSIA_TELP   = 'lansia_telp';
    const LANSIA_NAMA   = 'lansia_nama';
    const USER_ID       = 'user_id';
    const ID            = 'id';
    const CREATED_AT    = 'created_at';
    const UPDATED_AT    = 'updated_at';

    protected $table = 'lansia_posyandu';
    protected $primarykey = 'id';

    protected $timestamp = false;

    protected $fillable = [
        self::POSYANDU_ID,
        self::LANSIA_KODE,
        self::LANSIA_NIK,
        self::LANSIA_TELP,
        self::LANSIA_KK,
        self::LANSIA_ALAMAT,
        self::USER_ID
    ];

    protected $hidden = [
        self::CREATED_AT, self::UPDATED_AT, self::ID
    ];

    public function posyanduId() {
        return $this->belongsTo(MstPosyandu::class,'id','posyandu_id');
    }

    public function userId()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
