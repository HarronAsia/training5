<?php

namespace App\Repositories\Follower;

use App\Models\Follower;
use App\Repositories\BaseRepository;

use App\Models\Thread;


class FollowerRepository extends BaseRepository implements FollowerRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Follower::class;
    }

    public function showfollowers($threadid)
    {
         $thread = Thread::findOrFail($threadid); 
        
         return $this->model =  $thread->users();
               
    }

    public function showfollowerThread($id,$threadid)
    {        
        
        return $this->model =  Follower::where('follower_id',$id)->where('following_id',$threadid)->first();
    }

    public function showfollowerCommunity($id,$communityid)
    {        
     
        return $this->model =  Follower::get()->where('follower_id',$id)->where('following_id',$communityid)->first();
    }

}
