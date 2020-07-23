<?php

namespace App\Repositories\Thread\Tag;

use App\Repositories\BaseRepository;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;


class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Tag::class;
    }

    public function showall()
    {
        return $this->model->all();
    }

    public function showallnoTrash()
    {
        return $this->model = Tag::withTrashed()->paginate(5);
    }

    public function getTag($id)
    {
        return $this->model = Tag::findOrFail($id);
    }

    public function deletetag($id)
    {
        
        $this->model = Tag::findOrFail($id);
        
        return $this->model->delete();
    }

    public function restoretag($id)
    {
       
        return $this->model = Tag::onlyTrashed()->where('id',$id)->restore();      
        
    }

    public function getTrash($id)
    {
        
        return $this->model = Tag::withTrashed()->find($id);
    }
    
    public function getAllTags()
    {
        return $this->model = DB::table('tags')->paginate(5);
    }
}
