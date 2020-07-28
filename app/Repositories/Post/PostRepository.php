<?php

namespace App\Repositories\Post;

use App\Repositories\BaseRepository;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Post::class;
    }

    public function showall($id)
    {
        return $this->model = Post::with('comments','likes','like')->withTrashed()->where('community_id',$id)->paginate(5);
        
    }

    public function showpost($id)
    {
        return $this->model = Post::findOrFail($id);
    }

    public function deletepost($id)
    {
        
        $this->model = Post::findOrFail($id);
        
        return $this->model->delete();
    }

    public function restorepost($id)
    {
       
        return $this->model = Post::onlyTrashed()->where('id',$id)->restore();      
        
    }
    public function getTrash($id)
    {
        
        return $this->model = Post::withTrashed()->find($id);
    }

    public function getAllPosts()
    {
        return $this->model = DB::table('posts')->paginate(5);
    }
}
