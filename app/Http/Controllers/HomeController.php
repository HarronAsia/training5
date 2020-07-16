<?php

namespace App\Http\Controllers;

use App\Category;
use App\Forum;
use Illuminate\Http\Request;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Forum\ForumRepositoryInterface;

class HomeController extends Controller
{
    protected $forumRepo;
    protected $cateRepo;

    public function __construct(CategoryRepositoryInterface $cateRepo, ForumRepositoryInterface $forumRepo)
    {
        $this->middleware(['auth', 'verified']);
        $this->forumRepo = $forumRepo;
        $this->cateRepo = $cateRepo;
    }

    public function admin(Request $req)
    {
        return view('unauthorized')->withMessage("Admin");
    }
    public function manager(Request $req)
    {
        return view('unauthorized')->withMessage("Manager");
    }
    public function member(Request $req)
    {
        return view('unauthorized')->withMessage("Member");
    }

    public function index()
    {
        $categories = $this->cateRepo->showall();
        // $forum = Forum::find(1);
        // dd($forum->category->get());
        $forums = $this->forumRepo->showall();
        return view('home', compact('categories', 'forums'));
    }
}
