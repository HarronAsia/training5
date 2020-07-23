<?php

namespace App\Repositories\Thread;

interface ThreadRepositoryInterface
{

    public function getallThreads($id);

    public function addThread();

    public function getThread($id);

    public function showThread($id);

    public function deleteThreads($id);

    public function restoreThreads($id);

    public function getTrash($id);

    public function allThreads();

    public function count_users($id);

    public function getAllThreadsByManager();

    public function getAllThreadsByAdmin();
}
