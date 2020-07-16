<?php

namespace App\Http\Controllers;

use App\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Forum\ForumRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests\StoreCategory;
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
        return view('confirms.Category.add_category');
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
        return Redirect('/');
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
        $forums = $this->forumRepo->getForums($category->id);
        
        return view('confirms.Category.Forum.homepage',compact('category','forums'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
