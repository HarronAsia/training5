<?php

namespace App\Repositories\Notification;

use App\Models\Notification;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Notification::class;
    }



    public function showall()
    {
        return $this->model = DB::table('notifications')->withTrashed()->paginate(10);
    }

    public function showUnread()
    {
       return $this->model = DB::table('notifications')->get()->where('read_at', '==', NULL);
    }


}
