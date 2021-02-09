<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $user;
    public function __construct(User $user) {
        $this->user = $user;
    }

    public function findUserById($id)
    {
        # code...
        return User::find($id);
    }

    public function findUserByEmailAndPosyandu($email, $posyandu)
    {
        # code...
        return User::where('email','=',$email)->where('posyandu_id','=',$posyandu)->first();
    }
}
