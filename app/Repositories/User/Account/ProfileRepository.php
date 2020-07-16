<?php

namespace App\Repositories\User\Account;

use App\Repositories\BaseRepository;

use App\Profile;
use Illuminate\Support\Facades\DB;


class ProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Profile::class;
    }

    
}
