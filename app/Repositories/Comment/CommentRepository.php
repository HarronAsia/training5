<?php

namespace App\Repositories\Comment;

use App\Repositories\BaseRepository;
use App\Models\Comment;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Comment::class;
    }

    public function showall($id)
    {
        return $this->model = Comment::withTrashed()->get()->where('commentable_id','=',$id);
    }

    public function showComment($id)
    {
        return $this->model = Comment::findOrFail($id);
    }

    public function deletecomment($id)
    {
        
        $this->model = Comment::findOrFail($id);
        
        return $this->model->delete();
    }

    public function restorecomment($id)
    {
       
        return $this->model = Comment::onlyTrashed()->where('id',$id)->restore();
                  
    }

    public function getAllComments()
    {
        return $this->model = Comment::withTrashed()->paginate(5);
    }
   
}
