<?php
    namespace App\Repositories;

use App\Models\MstPosyandu;

class PosyanduRepository {
        protected $posyandu;

        public function __construct(MstPosyandu $posyandu)
        {
            $this->posyandu = $posyandu;
        }

        public function getAll() {
            return $this->posyandu->all();
        }

        public function findFirst($id)
        {
            return $this->posyandu->find($id);
        }

        public function findByColumn($column, $value)
        {
            return $this->posyandu->where($column, $value)->get();
        }
    }
