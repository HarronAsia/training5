<?php

namespace App\Http\Controllers;


use App\Models\Forum;

use App\Http\Requests\StoreForum;

use App\Notifications\Forum\AddForumNotification;
use App\Notifications\Forum\DeleteForumNotification;
use App\Notifications\Forum\EditForumNotification;
use App\Notifications\Forum\RestoreForumNotification;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Forum\ForumRepositoryInterface;
use App\Repositories\Thread\ThreadRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\User\Account\ProfileRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;

class ForumController extends Controller
{
    protected $forumRepo;
    protected $cateRepo;
    protected $threadRepo;
    protected $profileRepo;
    protected $notiRepo;

    public function __construct(ThreadRepositoryInterface $threadRepo, CategoryRepositoryInterface $cateRepo, ForumRepositoryInterface $forumRepo, ProfileRepositoryInterface $profileRepo, NotificationRepositoryInterface $notiRepo)
    {
        $this->middleware('auth');
        $this->forumRepo = $forumRepo;
        $this->cateRepo = $cateRepo;
        $this->threadRepo = $threadRepo;
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
    public function create($id)
    {

        $category = $this->cateRepo->showcategory($id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.Forum.add_forum', compact('category', 'notifications', 'profile'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreForum $request, $id)
    {

        $data = $request->validated();

        $category = $this->cateRepo->showcategory($id);

        $forum = new Forum;

        $forum->title = $data['title'];
        $forum->category_id = $category->id;
        $forum->save();
        $forum->notify(new AddForumNotification());
        return redirect()->route('category.index', $category->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $threadid)
    {


        $forum = $this->forumRepo->showforum($id);
        $threads = $this->threadRepo->getallThreads($threadid);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.Forum.Thread.homepage', compact('threads', 'forum', 'notifications','profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $forum = $this->forumRepo->showforum($id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.Category.Forum.edit', compact('forum', 'notifications','profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreForum $request, $id)
    {
        $data = $request->validated();

        $forum = $this->forumRepo->showforum($id);

        $forum->title = $data['title'];

        $forum->update();
        $forum->notify(new EditForumNotification());
        $category = $this->cateRepo->showcategory($forum->category_id);

        return redirect()->route('category.index', $category->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->forumRepo->deleteForums($id);
        $forum = $this->forumRepo->getTrash($id);
        $forum->notify(new DeleteForumNotification());
        

        return redirect()->back();
    }

    public function restore($id)
    {

        $this->forumRepo->restoreForums($id);

        $forum = $this->forumRepo->showforum($id);
        $forum->notify(new RestoreForumNotification());
        

        return redirect()->back();
    }
}
