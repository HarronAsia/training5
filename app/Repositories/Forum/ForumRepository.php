<?php

namespace App\Repositories\Forum;

use App\Repositories\BaseRepository;
use App\Models\Forum;
use Illuminate\Support\Facades\DB;
class ForumRepository extends BaseRepository implements ForumRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Forum::class;
    }

    public function showall($id)
    {
        return $this->model = Forum::with('threads')->withTrashed()->where('category_id',$id)->paginate(5);
    }

    public function showforum($id)
    {
        return $this->model = Forum::findOrFail($id);
    }

    public function deleteForums($id)
    {
        
        $this->model = Forum::findOrFail($id);
        
        return $this->model->delete();
    }

    public function restoreForums($id)
    {
       
        return $this->model = Forum::onlyTrashed()->where('id',$id)->restore();    
    }

    public function getTrash($id)
    {
        
        return $this->model = Forum::withTrashed()->find($id);
    }

    public function getAllForums()
    {
        return $this->model = DB::table('forums')->paginate(5);
    }
}
