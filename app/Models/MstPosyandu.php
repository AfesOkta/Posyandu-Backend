<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstPosyandu extends Model
{
    use HasFactory;

    const POSYANDU_KODE = 'posyandu_kode';
    const POSYANDU_NAMA = 'posyandu_nama';
    const ID = 'id';
    const CREATED_AT = 'created_at';
    const MODIFY_AT = 'modify_at';

    protected $table = 'mst_posyandu';
    protected $timestamp = true;

    protected $fillable = [
        self::ID,
        self::POSYANDU_KODE,
        self::POSYANDU_NAMA
    ];

    protected $hidden = [
        self::CREATED_AT,
        self::MODIFY_AT
    ];

    public function kader()
    {
        return $this->hasMany('App\Models\KaderPosyandu','posyandu_kode','posyandu_kode');
    }

    public function lansia()
    {
        return $this->hasMany('App\Models\LansiaPosyandu','posyandu_kode','posyandu_kode');
    }

    public function absensi()
    {
        return $this->hasMany('App\Models\AbsensiPosyandu','posyandu_kode','posyandu_kode');
    }

    public function user()
    {
        # code...
        return $this->hasMany('App\Models\UsersPosyandu','posyandu_kode','posyandu_kode');
    }
}
