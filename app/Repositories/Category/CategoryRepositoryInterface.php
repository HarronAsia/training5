<?php

namespace App\Repositories\Category;

interface CategoryRepositoryInterface
{
    public function showall();

    public function showcategory($id);

    public function deletecategory($id);
    public function restorecategory($id);
    public function getTrash($id);

    public function getAllCategories();
}
