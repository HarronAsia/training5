<?php

namespace App\Repositories\Forum;

interface ForumRepositoryInterface
{
    public function showall($id);
    public function showforum($id);
    public function deleteForums($id);
    public function restoreForums($id);
    public function getTrash($id);

    public function getAllForums();
}
