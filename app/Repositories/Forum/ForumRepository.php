<?php

namespace App\Repositories\Forum;

use App\Repositories\BaseRepository;
use App\Forum;
use Illuminate\Support\Facades\DB;

class ForumRepository extends BaseRepository implements ForumRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Forum::class;
    }

    public function showall()
    {
        return $this->model = DB::table('forums')->paginate(10);
    }

    public function showforum($id)
    {
        return $this->model = Forum::findOrFail($id);
    }

    public function getForums($id)
    {

        return $this->model =  DB::table('forums')->where('category_id', '=', $id)->paginate(10);
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
}
