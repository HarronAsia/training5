<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCategory;

use App\Notifications\Category\AddCategoryNotification;
use App\Notifications\Category\DeleteCategoryNotification;
use App\Notifications\Category\EditCategoryNotification;
use App\Notifications\Category\RestoreCategoryNotification;

use App\Repositories\Forum\ForumRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\User\Account\ProfileRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;

class CategoryController extends Controller
{

    protected $cateRepo;
    protected $forumRepo;
    protected $profileRepo;
    protected $notiRepo;

    public function __construct(CategoryRepositoryInterface $cateRepo, ForumRepositoryInterface $forumRepo, ProfileRepositoryInterface $profileRepo, NotificationRepositoryInterface $notiRepo)
    {
        $this->middleware('auth');
        $this->cateRepo = $cateRepo;
        $this->forumRepo = $forumRepo;
        $this->profileRepo = $profileRepo;
        $this->notiRepo = $notiRepo;
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
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.Category.add_category', compact('notifications', 'profile'));
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
        
        return redirect()->route('home');
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
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.Category.Forum.homepage', compact('category', 'forums', 'notifications','profile'));
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
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.Category.edit_category', compact('category', 'notifications','profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategory $request, $id)
    {
        $data = $request->validated();

        $category = $this->cateRepo->showcategory($id);

        $category->name = $data['name'];
        $category->detail = $data['detail'];

        $category->save();
        $category->notify(new EditCategoryNotification());
        return redirect()->route('home');
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
        return redirect()->back();
    }

    public function restore($id)
    {
        $this->cateRepo->restorecategory($id);
        $category = $this->cateRepo->showcategory($id);
        $category->notify(new RestoreCategoryNotification());
        return redirect()->back();
    }
}
