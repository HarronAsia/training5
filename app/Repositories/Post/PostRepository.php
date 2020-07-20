<?php

namespace App\Repositories\Post;

use App\Repositories\BaseRepository;
use App\Post;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Post::class;
    }

    public function showall($id)
    {
        return $this->model = DB::table('posts')->where('community_id','=',$id)->where('deleted_at',NULL)
        ->paginate(5);;
    }

    public function showallforAdmin($id)
    {
        return $this->model = DB::table('posts')->where('community_id','=',$id)->paginate(5);
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
}
