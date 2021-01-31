<?php
namespace App\Repositories;

use App\Models\LansiaPosyandu;

class AnggotaRepository
{
    protected $lansiaPosyandu;
    protected $posyanduRepo;
    public function __construct(LansiaPosyandu $lansiaPosyandu)
    {
        $this->lansiaPosyandu = $lansiaPosyandu;
    }

    public function getAll() {
        return $this->lansiaPosyandu->all();
    }

    public function findFirst($id)
    {
        return $this->lansiaPosyandu->find($id);
    }

    public function findByColumn($column, $value)
    {
        return $this->lansiaPosyandu->where($column, $value)->get();
    }

}
