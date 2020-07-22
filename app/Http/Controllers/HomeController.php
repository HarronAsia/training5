<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use App\Repositories\Forum\ForumRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use Carbon\Carbon;

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

        $notifications = DB::table('notifications')->get()->where('read_at', '==', NULL);
        return view('home', compact('categories', 'notifications'));
    }

    public function readAt($id)
    {
        $notification = DB::table('notifications')->where('id', $id)->update(['read_at' => Carbon::now()]);



        return redirect()->back();
    }
}
