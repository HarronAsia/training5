<?php
namespace App\Repositories\Follower;

interface FollowerRepositoryInterface
{

    
    public function showfollowers($threadid);

    public function showfollowerThread($id,$threadid);

    public function showfollowerCommunity($id,$communityid);
}