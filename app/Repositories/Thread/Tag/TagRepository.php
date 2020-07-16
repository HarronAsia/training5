<?php

namespace App\Repositories\Thread\Tag;

use App\Repositories\BaseRepository;

use App\Tag;
use Illuminate\Support\Facades\DB;


class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Tag::class;
    }

    public function showall()
    {
        return $this->model->all();
    }

    public function getTag($id)
    {
        return $this->model = Tag::findOrFail($id);
    }
}
