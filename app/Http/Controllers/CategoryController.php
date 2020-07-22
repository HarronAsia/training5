<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCategory;

use App\Notifications\Category\AddCategoryNotification;
use App\Notifications\Category\DeleteCategoryNotification;
use App\Notifications\Category\EditCategoryNotification;
use App\Notifications\Category\RestoreCategoryNotification;

use App\Repositories\Forum\ForumRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryController extends Controller
{

    protected $cateRepo;
    protected $forumRepo;

    public function __construct(CategoryRepositoryInterface $cateRepo,ForumRepositoryInterface $forumRepo)
    {
        $this->middleware('auth');
        $this->cateRepo = $cateRepo;
        $this->forumRepo = $forumRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notifications = DB::table('notifications')->get()->where('read_at','==',NULL);
        return view('confirms.Category.add_category',compact('notifications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategory $request)
    {
        $data = $request->validated();

        $category = new Category;

        $category->name = $data['name'];
        $category->detail = $data['detail'];

        $category->save();

      
        $category->notify(new AddCategoryNotification);
        $notifications = DB::table('notifications')->get()->where('read_at','==',NULL);
        return Redirect('/')->with('notifications',$notifications);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->cateRepo->showcategory($id);
        $forums = $this->forumRepo->showall($category->id);
        $notifications = DB::table('notifications')->get()->where('read_at','==',NULL);
        return view('confirms.Category.Forum.homepage',compact('category','forums','notifications'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->cateRepo->showcategory($id);
        $notifications = DB::table('notifications')->get()->where('read_at','==',NULL);
        return view('confirms.Category.edit_category',compact('category','notifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategory $request,$id)
    {
        $data = $request->validated();

        $category = $this->cateRepo->showcategory($id);

        $category->name = $data['name'];
        $category->detail = $data['detail'];

        $category->save();
        $category->notify(new EditCategoryNotification());
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->cateRepo->deletecategory($id);
        $category = $this->cateRepo->getTrash($id);
        
        $category->notify(new DeleteCategoryNotification());
        return redirect('/');
    }

    public function restore($id)
    {
        $this->cateRepo->restorecategory($id);
        $category = $this->cateRepo->showcategory($id);
        $category->notify(new RestoreCategoryNotification());
        return redirect('/');
    }
}
