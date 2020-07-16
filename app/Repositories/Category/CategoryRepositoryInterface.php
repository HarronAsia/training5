<?php
namespace App\Repositories\Category;
interface CategoryRepositoryInterface
{
    public function showall();

    public function showcategory($id);
}