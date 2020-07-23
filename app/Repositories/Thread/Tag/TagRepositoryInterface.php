<?php

namespace App\Repositories\Thread\Tag;

interface TagRepositoryInterface
{
    public function showall();
    public function showallnoTrash();
    
    public function getTag($id);
 
    public function deletetag($id);
    public function restoretag($id);
    public function getTrash($id);

    public function getAllTags();
}
