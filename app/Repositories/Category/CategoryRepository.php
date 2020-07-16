<?php

namespace App\Repositories\Category;

use App\Repositories\BaseRepository;
use App\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Category::class;
    }

    public function showall()
    {
        return $this->model = DB::table('categories')->paginate(10);
    }

    public function showcategory($id)
    {
        return $this->model = Category::findOrFail($id);
    }
   
}
