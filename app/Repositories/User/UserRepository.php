<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;

use App\Models\User;
use Illuminate\Support\Facades\DB;


class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function showUser($id)
    {

        return $this->model = User::findOrFail($id);
    }


    public function allUsers()
    {
        return $this->model = DB::table('users')->paginate(5);
    }
}
