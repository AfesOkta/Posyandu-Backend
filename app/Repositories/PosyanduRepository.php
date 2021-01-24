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
            return $this->posyandu->all()->sortByDesc('created_at');
        }

        public function findFirst($id)
        {
            return $this->posyandu->find($id);
        }

        public function findByColumn($column, $value)
        {
            return $this->posyandu->where($column, $value)->get();
        }

        public function create($validateData)
        {
            $data = [
                MstPosyandu::POSYANDU_KODE => $validateData['posyandu_kode'],
                MstPosyandu::POSYANDU_NAMA => $validateData['posyandu_nama'],
            ];
            return $this->posyandu->create($data);
        }
    }
