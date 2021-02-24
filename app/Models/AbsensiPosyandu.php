<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiPosyandu extends Model
{
    use HasFactory;
    const LANSIA_ID     = 'lansia_id';
    const POSYANDU_ID   = 'posyandu_kode';
    const KADER_ID      = 'kader_id';
    const MASUK         = 'masuk';
    const PULANG        = 'pulang';
    const CREATED_AT    = 'created_at';
    const UPDATED_AT    = 'updated_at';
    const ID            = 'id';
    const STATUS        = 'status';

    protected $table = 'absensi_posyandu';
    protected $timestamp = true;

    protected $fillable = [
        self::LANSIA_ID,
        self::POSYANDU_ID,
        self::KADER_ID,
        self::MASUK,
        self::PULANG,
        self::ID,
        self::STATUS
    ];

    protected $hidden = [
        self::CREATED_AT,
        self::UPDATED_AT
    ];

    public function posyandu() {
        return $this->belongsTo(MstPosyandu::class,'posyandu_kode','posyandu_kode');
    }

    public function anggota() {
        return $this->belongsTo(LansiaPosyandu::class,'lansia_id','id');
    }

    public function kader() {
        return $this->belongsTo(KaderPosyandu::class,'kader_id','id');
    }
}
