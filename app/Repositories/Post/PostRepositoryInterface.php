<?php

namespace App\Repositories\Post;

interface PostRepositoryInterface
{
    public function showall($id);
    public function showpost($id);

    public function deletepost($id);
    public function restorepost($id);

    public function getTrash($id);
}
