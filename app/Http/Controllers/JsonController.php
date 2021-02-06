<?php

namespace App\Http\Controllers;

use App\Repositories\PosyanduRepository;
use Illuminate\Http\Request;

class JsonController extends Controller
{
    //
    protected $posyanduRepo;
    public function __construct(PosyanduRepository $posyanduRepo) {
        $this->posyanduRepo = $posyanduRepo;
    }

    public function posyandu()
    {
        # code...
        return response()->json($this->posyanduRepo->getAll());
    }
}
