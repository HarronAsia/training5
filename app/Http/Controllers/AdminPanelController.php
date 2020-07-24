<?php

namespace App\Http\Controllers;

use App\Models\AdminPanel;
use Illuminate\Http\Request;

use App\Http\Requests\StoreAdmin;
use Illuminate\Support\Facades\Auth;

use App\Repositories\Admin\AdminRepositoryInterface;

use App\Repositories\User\Account\ProfileRepositoryInterface;

use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Report\ReportRepositoryInterface;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Forum\ForumRepositoryInterface;
use App\Repositories\Thread\ThreadRepositoryInterface;
use App\Repositories\Thread\Tag\TagRepositoryInterface;
use App\Repositories\Community\CommunityRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;

class AdminPanelController extends Controller
{
    protected $adminRepo;

    protected $profileRepo;

    protected $notiRepo;
    protected $commRepo;
    protected $repoRepo;

    protected $cateRepo;
    protected $forumRepo;
    protected $threadRepo;
    protected $tagRepo;
    protected $commuRepo;
    protected $postRepo;

    public function __construct(AdminRepositoryInterface $adminRepo, ProfileRepositoryInterface $profileRepo, NotificationRepositoryInterface $notiRepo, 
                            ThreadRepositoryInterface $threadRepo, PostRepositoryInterface $postRepo, CommentRepositoryInterface $commRepo, ReportRepositoryInterface $repoRepo,
                            CategoryRepositoryInterface $cateRepo, ForumRepositoryInterface $forumRepo, TagRepositoryInterface $tagRepo, CommunityRepositoryInterface $commuRepo)
    {
        $this->middleware('auth');
        $this->adminRepo = $adminRepo;

        $this->profileRepo = $profileRepo;

        $this->notiRepo = $notiRepo;
        $this->commRepo = $commRepo;
        $this->repoRepo = $repoRepo;

        $this->cateRepo = $cateRepo;
        $this->forumRepo = $forumRepo;
        $this->threadRepo = $threadRepo;
        $this->tagRepo = $tagRepo;
        $this->commuRepo = $commuRepo;
        $this->postRepo = $postRepo;
    }

    public function index()
    {

        $users = $this->adminRepo->countAllUsers();
        $managers = $this->adminRepo->countAllManagers();
        $admins = $this->adminRepo->countAllAdmins();


        $categories = $this->adminRepo->countAllCategories();
        $forums = $this->adminRepo->countAllForums();

        $managers_threads = $this->adminRepo->countAllThreadsByManager();
        $admins_threads = $this->adminRepo->countAllThreadsByAdmin();

        $tags = $this->adminRepo->countAllTags();

        $communities = $this->adminRepo->countAllCommunities();
        $posts = $this->adminRepo->countAllPosts();

        $comments = $this->adminRepo->countAllComments();
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);

        $reports = $this->adminRepo->countAllReports();

        return view('admin.dashboard', compact('users', 'managers', 'admins', 'categories', 'forums', 'managers_threads', 'admins_threads', 'tags', 
                                                'communities', 'posts', 'comments', 'notifications', 'profile','reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AdminPanel  $adminPanel
     * @return \Illuminate\Http\Response
     */
    public function show(AdminPanel $adminPanel)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AdminPanel  $adminPanel
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminPanel $adminPanel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AdminPanel  $adminPanel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminPanel $adminPanel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdminPanel  $adminPanel
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminPanel $adminPanel)
    {
        //
    }

    //*===============For User=============================*//
    public function users()
    {
        $users = $this->adminRepo->getAllUsers();
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.users_list', compact('users', 'notifications', 'profile'));
    }

    public function editmember($id)
    {
        $user = $this->adminRepo->findAccount($id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.users.edit_user', compact('user', 'notifications', 'profile'));
    }

    public function confirmMember(StoreAdmin $request, $id)
    {

        $value = $this->adminRepo->findAccount($id);

        $user = $this->adminRepo->confirmAdmin($request, $value->id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.admin.edituser', compact('user', 'notifications', 'profile'));
    }

    public function updateusers($id)
    {
        $user = $this->adminRepo->findAccount($id);

        $this->adminRepo->editforAdmin($user->id);

        return redirect()->route('user.list');
    }

    public function destroyusers($id)
    {
        $user = $this->adminRepo->findAccount($id);
        $user->delete();
        return redirect()->back();
    }
    //*===============For User=============================*//

    //*===============For Manager=============================*//
    public function managers()
    {
        $users = $this->adminRepo->getAllManagers();
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.managers_lists', compact('users', 'notifications', 'profile'));
    }

    public function editmanager($id)
    {
        $user = $this->adminRepo->findAccount($id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.managers.edit_manager', compact('user', 'notifications', 'profile'));
    }

    public function confirmManager(StoreAdmin $request, $id)
    {
        $value = $this->adminRepo->findAccount($id);

        $user = $this->adminRepo->confirmAdmin($request, $value->id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.admin.editmanager', compact('user', 'notifications', 'profile'));
    }

    public function updatemanagers($id)
    {
        $user = $this->adminRepo->findAccount($id);
        $this->adminRepo->editforAdmin($user->id);

        return redirect()->route('manager.list');
    }

    public function destroymanagers($id)
    {
        $user = $this->adminRepo->findAccount($id);
        $user->delete();
        return redirect()->back();
    }
    //*===============For Manager=============================*//

    //*===============For Admin=============================*//
    public function admins()
    {
        $users = $this->adminRepo->getAllAdmins();
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.admins_lists', compact('users', 'notifications', 'profile'));
    }

    public function editadmin($id)
    {
        $user = $this->adminRepo->findAccount($id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.admins.edit_admin', compact('user', 'notifications', 'profile'));
    }

    public function confirmforAdmin(StoreAdmin $request, $id)
    {
        $value = $this->adminRepo->findAccount($id);

        $user = $this->adminRepo->confirmAdmin($request, $value->id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.admin.edit', compact('user', 'notifications', 'profile'));
    }

    public function updateadmins($id)
    {
        $user = $this->adminRepo->findAccount($id);

        $this->adminRepo->editforAdmin($user->id);

        return redirect()->route('admin.list');
    }

    public function destroyadmins($id)
    {
        $user = $this->adminRepo->findAccount($id);
        $user->delete();
        return redirect()->back();
    }

    //*===============For Admin=============================*//

    //*===============For Admins Categories=============================*//
    public function Categories()
    {

        $categories = $this->cateRepo->getAllCategories();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Category.categories_lists', compact('categories', 'notifications', 'profile'));
    }

    //*===============For Admins Categories=============================*//

    //*===============For Admins Forums=============================*//
    public function Forums()
    {

        $forums = $this->forumRepo->getAllForums();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Forum.forums_lists', compact('forums', 'notifications', 'profile'));
    }

    //*===============For Admins Forums=============================*//

    //*===============For Admins Threads=============================*//
    public function AdminsThreads()
    {

        $threads = $this->threadRepo->getAllThreadsByAdmin();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Thread.AdminThreads.admins_lists', compact('threads', 'notifications', 'profile'));
    }

    //*===============For Admins Threads=============================*//

    //*===============For Admins Threads=============================*//
    public function ManagersThreads()
    {

        $threads = $this->threadRepo->getAllThreadsByManager();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Thread.ManagerThreads.managers_lists', compact('threads', 'notifications', 'profile'));
    }

    //*===============For Admins Threads=============================*//

    //*===============For Admins Tags=============================*//
    public function Tags()
    {
        $tags = $this->tagRepo->getAllTags();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Tag.tags_lists', compact('tags', 'notifications', 'profile'));
    }

    //*===============For Admins Tags=============================*//

    //*===============For Admins Communities=============================*//
    public function Communities()
    {
        $communities = $this->commuRepo->getAllCommunities();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Community.communities_lists', compact('communities', 'notifications', 'profile'));
    }

    //*===============For Admins Communities=============================*//

    //*===============For Admins Posts=============================*//
    public function Posts()
    {

        $posts = $this->postRepo->getAllPosts();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Post.posts_lists', compact('posts', 'notifications', 'profile'));
    }

    //*===============For Admins Posts=============================*//

    //*===============For Admins Comments=============================*//
    public function Comments()
    {

        $comments = $this->commRepo->getAllComments();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.lists.Comment.comments_lists', compact('comments', 'notifications', 'profile'));
    }

    //*===============For Admins Comments=============================*//

     //*===============For Admins Reports=============================*//
     public function Reports()
     {
 
         $reports = $this->repoRepo->showall();
 
         $notifications = $this->notiRepo->showUnread();
         $profile = $this->profileRepo->getProfile(Auth::user()->id);
         return view('admin.lists.Report.reports_lists', compact('reports', 'notifications', 'profile'));
     }
 
     //*===============For Admins Reports=============================*//
}
