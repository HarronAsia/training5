<?php

namespace App\Repositories\Category;

use App\Repositories\BaseRepository;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Category::class;
    }

    public function showall()
    {
        return $this->model = Category::with('forums')->withTrashed()->paginate(5);
    }

    public function showcategory($id)
    {
        return $this->model = Category::findOrFail($id);
    }

    public function deletecategory($id)
    {
        
        $this->model = Category::findOrFail($id);
        
        return $this->model->delete();
    }

    public function restorecategory($id)
    {
       
        return $this->model = Category::onlyTrashed()->where('id',$id)->restore();
               
    }
    public function getTrash($id)
    {
        
        return $this->model = Category::withTrashed()->find($id);
    }
   
    public function getAllCategories()
    {
        return $this->model = DB::table('categories')->paginate(5);
    }
}
