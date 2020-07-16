<?php
namespace App\Repositories\Thread\Tag;

interface TagRepositoryInterface
{
    public function showall();

    public function getTag($id);
}