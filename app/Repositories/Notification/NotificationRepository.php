<?php

namespace App\Repositories\Notification;

use Carbon\Carbon;
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
        return $this->model = DB::table('notifications')->paginate(5);
    }

    public function showallUnread()
    {
        return $this->model = DB::table('notifications')->get()->where('read_at', '=', NULL);
    }

    public function showUnread()
    {
       return $this->model = DB::table('notifications')->get()->where('read_at', '=', NULL);
    }

    public function readAt($id)
    {
        return $this->model =  DB::table('notifications')->where('id', $id)->update(['read_at' => Carbon::now()]);
    }

    public function readAll()
    {
        return $this->model =DB::table('notifications')->update(['read_at' => Carbon::now()]);
    }

    public function deleteNotification($id)
    {
        $this->model = Notification::findOrFail($id);

        return $this->model->delete();
    }
}
