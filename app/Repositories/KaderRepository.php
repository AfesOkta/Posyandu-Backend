<?php
namespace App\Repositories;

use App\Models\KaderPosyandu;

class KaderRepository
{
    protected $kaderPosyandu;
    public function __construct(KaderPosyandu $kaderPosyandu)
    {
        $this->kaderPosyandu = $kaderPosyandu;
    }

    public function getAll() {
        return $this->kaderPosyandu->all();
    }

    public function findFirst($id)
    {
        return $this->kaderPosyandu->find($id);
    }

    public function findByColumn($column, $value)
    {
        return $this->kaderPosyandu->where($column, $value)->get();
    }
}
