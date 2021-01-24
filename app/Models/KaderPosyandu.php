<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaderPosyandu extends Model
{
    use HasFactory;
    const POSYANDU_ID   = 'posyandu_id';
    const KADER_KODE    = 'kader_kode';
    const KADER_NIK     = 'kader_nik';
    const KADER_KK      = 'kader_kk';
    const KADER_ALAMAT  = 'kader_alamat';
    const KADER_TELP    = 'kader_telp';
    const KADER_NAMA    = 'kader_nama';
    const USER_ID       = 'user_id';
    const ID            = 'id';
    const CREATED_AT    = 'created_at';
    const UPDATED_AT    = 'updated_at';

    protected $table = 'kader_posyandu';
    protected $primarykey = 'id';

    protected $timestamp = false;

    protected $fillable = [
        self::POSYANDU_ID,
        self::KADER_KODE,
        self::KADER_NIK,
        self::KADER_TELP,
        self::KADER_KK,
        self::KADER_ALAMAT,
        self::USER_ID,
        self::KADER_NAMA
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
