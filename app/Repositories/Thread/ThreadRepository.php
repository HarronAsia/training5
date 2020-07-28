<?php

namespace App\Repositories\Thread;

use App\Repositories\BaseRepository;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThreadRepository extends BaseRepository implements ThreadRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Thread::class;
    }

    public function getallThreads($id)
    {
        return $this->model = DB::table('threads')->where('forum_id', $id)->paginate(5);
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

        return $this->model = Thread::onlyTrashed()->where('id', $id)->restore();
    }

    public function getTrash($id)
    {

        return $this->model = Thread::withTrashed()->find($id);
    }

    public function getThread($id)
    {
        return $this->model = Thread::withTrashed()->with('comments', 'likes','like')->where('id', $id)->paginate(10);
    }

    public function showThread($id)
    {

        DB::table('threads')->where('id', $id)->increment('count_id', 1);
        return $this->model = Thread::findOrFail($id);
    }

    public function allThreads()
    {
        return $this->model = DB::table('threads')->paginate(5);
    }

    public function count_users($id)
    {

        return $numbers = DB::table('users')->get()->where('join_id', '=', $id)->count();

        $this->model = DB::table('threads')->where('id', '=', $id)->update(['count_id' => $numbers]);
    }

    public function getAllThreadsByManager()
    {
        return $this->model = DB::table('threads')->join('users', 'user_id', '=', 'users.id')->where('role', '"manager"')->select('threads.*')->paginate(5);
    }

    public function getAllThreadsByAdmin()
    {

        return $this->model = DB::table('threads')->join('users', 'user_id', '=', 'users.id')->where('role', '"admin"')->select('threads.*')->paginate(5);
    }

//     public function getAllThreadsbyEachUser()
//     {
//         return $this->model = Thread::join('users', 'user_id', '=', 'users.id')
//     }
}
