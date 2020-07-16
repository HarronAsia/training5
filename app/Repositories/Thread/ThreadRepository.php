<?php

namespace App\Repositories\Thread;

use App\Repositories\BaseRepository;
use App\Thread;
use Illuminate\Support\Facades\DB;

class ThreadRepository extends BaseRepository implements ThreadRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Thread::class;
    }

    public function getallThreads($id)
    {

        return $this->model = DB::table('threads')->where('forum_id',$id )
        ->where('deleted_at',NULL)
        ->paginate(20);
    }

    public function getallThreadsforAdmin($id)
    {

        return $this->model = DB::table('threads')->where('forum_id',$id )->paginate(20);
    }

    public function addThread()
    {

        return $this->model->all();
    }

    public function deleteThreads($id)
    {
        
        $this->model = Thread::findOrFail($id);
        
        return $this->model->delete();
    }

    public function restoreThreads($id)
    {
        
        return $this->model = Thread::onlyTrashed()->where('id',$id)->restore();
        
        
    }


    public function showThread($id)
    {
        return $this->model = Thread::findOrFail($id);
    }

    public function allThreads()
    {
        return $this->model = DB::table('threads')->join('users', 'user_id', 'users.id')->get()->where('role', '!=', 'member');
    }

    public function count_users($id)
    {

        return $numbers = DB::table('users')->get()->where('join_id', '=', $id)->count();

        $this->model = DB::table('threads')->where('id', '=', $id)->update(['count_id' => $numbers]);
    }
}
