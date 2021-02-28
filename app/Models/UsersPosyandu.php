<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersPosyandu extends Model
{
    use HasFactory;
    const ID = 'id';
    const USER = 'user_id';
    const POSYANDU = 'posyandu_kode';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $table = 'users_posyandu';
    protected $timestamp = true;

    protected $fillable = [
        self::ID,
        self::USER,
        self::POSYANDU
    ];

    protected $hidden = [
        self::CREATED_AT, self::UPDATED_AT
    ];

    public function User()
    {
        # code...
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function posyandu()
    {
        # code...
        return $this->hasMany('App\Models\MstPosyandu','posyandu_kode','posyandu_kode');
    }
}
