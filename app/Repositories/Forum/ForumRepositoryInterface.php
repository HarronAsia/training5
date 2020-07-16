<?php

namespace App\Repositories\Forum;

interface ForumRepositoryInterface
{
    public function showall();
    public function showforum($id);
    public function getForums($id);
    public function deleteForums($id);
    public function restoreForums($id);
}
