<?php

namespace App\Http\Controllers;


use App\Models\Forum;

use App\Http\Requests\StoreForum;

use App\Notifications\For_ADMIN\Forum\AddForumNotification;
use App\Notifications\For_ADMIN\Forum\DeleteForumNotification;
use App\Notifications\For_ADMIN\Forum\EditForumNotification;
use App\Notifications\For_ADMIN\Forum\RestoreForumNotification;

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

        $forum = new Forum;
        $forum->user_id = Auth::user()->id;
        $forum->title = $data['title'];
        $forum->category_id = $id;
        $forum->save();
        $forum->notify(new AddForumNotification());
        if(Auth::user()->role == 'manager')
        {
            return redirect()->route('manager.category.index', $id);
        }
        else
        {
            return redirect()->route('admin.category.index', $id);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $threadid)
    {

        if (Auth::guest()) {
            $forum = $this->forumRepo->showforum($id);
            $threads = $this->threadRepo->getallThreads($forum->id);
            return view('confirms.Thread.homepage', compact('threads', 'forum'));
        } else {
            $forum = $this->forumRepo->showforum($id);
            $threads = $this->threadRepo->getallThreads($forum->id);
            $notifications = $this->notiRepo->showUnread();
            $profile = $this->profileRepo->getProfile(Auth::user()->id);
            return view('confirms.Thread.homepage', compact('threads', 'forum', 'notifications', 'profile'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$forumid)
    {
        
        $forum = $this->forumRepo->showforum($forumid);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.Forum.edit', compact('forum', 'notifications', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreForum $request, $id,$forumid)
    {
        $data = $request->validated();
        
        $forum = $this->forumRepo->showforum($forumid);

        $forum->title = $data['title'];
        $forum->user_id = Auth::user()->id;
        $forum->update();
        $forum->notify(new EditForumNotification());
       
        if(Auth::user()->role == 'manager')
        {
            return redirect()->route('manager.category.index', $id);
        }
        else
        {
            return redirect()->route('admin.category.index', $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$forumid)
    {

        $this->forumRepo->deleteForums($forumid);
        $forum = $this->forumRepo->getTrash($forumid);
        $forum->notify(new DeleteForumNotification());


        return redirect()->back();
    }

    public function restore($id,$forumid)
    {

        $this->forumRepo->restoreForums($forumid);

        $forum = $this->forumRepo->showforum($forumid);
        $forum->notify(new RestoreForumNotification());


        return redirect()->back();
    }
}
