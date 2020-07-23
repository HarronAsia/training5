<?php

namespace App\Repositories\Community;

interface CommunityRepositoryInterface
{
    public function showall();
    public function showcommunity($id);
    public function deletecommunity($id);
    public function restorecommunity($id);
    public function getTrash($id);

    public function getAllCommunities();
}
