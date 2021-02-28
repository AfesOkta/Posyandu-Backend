<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    public function findAksesPosyandu($user)
    {
        # code...
        return DB::table('users_posyandu')
            ->where('user_id',$user)->get();
    }

    public function findAll()
    {
        # code...
        return $this->user->with('userposyandu')->get();
    }
}
