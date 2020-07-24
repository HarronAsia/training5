<?php

namespace App\Http\Controllers;

use Excel;

use App\Models\User;
use App\Models\Forum;
use App\Models\Thread;

use Illuminate\Http\Request;
use App\Exports\ThreadsExport;

use App\Imports\ThreadsImport;
use App\Http\Requests\StoreThread;

use Illuminate\Support\Facades\DB;


use App\Notifications\Thread\AddThreadNotification;
use App\Notifications\Thread\EditThreadNotification;
use App\Notifications\Thread\DeleteThreadNotification;
use App\Notifications\Thread\RestoreThreadNotification;
use App\Notifications\Thread\GetFollowThreadNotfication;
use App\Notifications\Thread\GetunFollowThreadNotfication;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Repositories\Forum\ForumRepositoryInterface;
use App\Repositories\Thread\ThreadRepositoryInterface;
use App\Repositories\Thread\Tag\TagRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\User\Account\ProfileRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Follower\FollowerRepositoryInterface;

class ThreadController extends Controller
{
    protected $threadRepo;
    protected $tagRepo;
    protected $forumRepo;
    protected $commRepo;
    protected $profileRepo;
    protected $notiRepo;
    protected $userRepo;
    protected $followRepo;

    public function __construct(ThreadRepositoryInterface $threadRepo, TagRepositoryInterface $tagRepo, ForumRepositoryInterface $forumRepo, CommentRepositoryInterface $commRepo, 
                                ProfileRepositoryInterface $profileRepo, NotificationRepositoryInterface $notiRepo,UserRepositoryInterface $userRepo,
                                FollowerRepositoryInterface $followRepo)

    {
        $this->threadRepo = $threadRepo;
        $this->tagRepo = $tagRepo;
        $this->forumRepo = $forumRepo;
        $this->commRepo = $commRepo;
        $this->profileRepo = $profileRepo;
        $this->notiRepo = $notiRepo;
        $this->userRepo = $userRepo;
        $this->followRepo = $followRepo;
    }

    public function index($id)
    {

        $forum = $this->forumRepo->showforum($id);

        $threads = $this->threadRepo->getallThreads($forum->id);

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.Forum.Thread.homepage', compact('threads', 'forum', 'notifications', 'profile'));
    }

    public function create($id)
    {
        $forum = $this->forumRepo->showforum($id);
        $threads = $this->threadRepo->addThread();
        $tags = $this->tagRepo->showall();
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);

        return view('confirms.Thread.add_thread', compact('threads', 'tags', 'forum', 'notifications', 'profile'));
    }

    //Confirm Add thread---------------------------------------------------------------
    public function confirmadd(StoreThread $request, $id)
    {

        $data = $request->validated();
        $thread = new Thread();

        $forum = Forum::findOrFail($id);
        

        $data['user_id'] = Auth::user()->id;

        $tag = $this->tagRepo->getTag($data['tag_id']);
        if ($request->hasFile('thumbnail')) {

            $thread->thumbnail = $request->file('thumbnail');

            $extension = $thread->thumbnail->getClientOriginalExtension();
            $filename = $data['title'] . '.' . $extension;
            $path = storage_path('app/public/thread/' . $data['title'] . '/');

            $thread->thumbnail->move($path, $filename);
        }
        $data['thumbnail'] = $filename;
        // Session::put('tag_id', $data['tag_id']);
        // Session::put('user_id', $data['user_id']);
        // Session::put('forum_id', $forum->id);
        // Session::put('title', $data['title']);
        // Session::put('detail', $data['detail']);
        // Session::put('status', $data['status']);

        // Session::put('thumbnail', $data['thumbnail']);

        // $thread = $value = Session::all();
        $thread->tag_id = $data['tag_id'];
        $thread->user_id = $data['user_id'];
        $thread->forum_id = $forum->id;
        $thread->title = $data['title'];
        $thread->detail = $data['detail'];
        $thread->status = $data['status'];
        $thread->thumbnail = $data['thumbnail'];
        
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);

        return view('confirms.Thread.confirm_add_thread', compact('thread', 'tag', 'forum', 'notifications', 'profile'));
    }
    //Confirm Add thread-------------------------------------------------------------

    public function store(StoreThread $request,$id)
    {
        dd($request);
        $data = $request->validated();
        $thread = new Thread();

        $thread->user_id = Session::get('user_id');
        $thread->title = Session::get('title');
        $thread->detail = Session::get('detail');
        $thread->status = Session::get('status');
        $thread->tag_id = Session::get('tag_id');
        $thread->forum_id = Session::get('forum_id');
        $thread->thumbnail  = Session::get('thumbnail');

        $thread->save();
        $thread->notify(new AddThreadNotification());

        return redirect()->route('thread.show', $id);
    }

    public function edit($id, $threadid)
    {
        
        $forum = $this->forumRepo->showforum($id);
        $thread = $this->threadRepo->showThread($threadid);
        
        $tags = $this->tagRepo->showall();
        $threadtag = $this->tagRepo->getTag($thread->tag_id);

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.Thread.edit', compact('thread', 'tags', 'threadtag', 'forum', 'notifications', 'profile'));
    }

    public function confirmupdate(StoreThread $request, $id, $threadid)
    {

        $data = $request->validated();

        $forum = $this->forumRepo->showforum($id);
        $value = $this->threadRepo->showThread($threadid);

        $tag = $this->tagRepo->getTag($data['tag_id']);

        $data['id'] =    $value->id;
        $data['user_id'] =   $value->user_id;

        Session::put('id', $data['id']);
        Session::put('user_id', $data['user_id']);
        Session::put('tag_id', $data['tag_id']);
        Session::put('forum_id',  $forum->id);
        Session::put('title', $data['title']);
        Session::put('detail', $data['detail']);
        Session::put('status', $data['status']);

        $old_thumbnail = $value->thumbnail;

        if ($request->hasFile('thumbnail')) {

            $value->thumbnail = $request->file('thumbnail');

            $extension = $value->thumbnail->getClientOriginalExtension();
            $filename =  Session::get('title') . '.' . $extension;

            $path = storage_path('app/public/thread/' . Session::get('title') . '/');

            if (!file_exists($path . $filename)) {

                $value->thumbnail->move($path, $filename);
            } else if (!file_exists($path . $old_thumbnail)) {

                $value->thumbnail->move($path, $filename);
            } else {

                unlink($path . $old_thumbnail);
                $value->thumbnail->move($path, $filename);
            }
        }
        $value->thumbnail = $filename;
        Session::put('thumbnail', $value->thumbnail);

        $thread = $value = Session::all();
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);

        return view('confirms.Thread.confirm_edit_thread', compact('thread', 'tag', 'forum', 'notifications', 'profile'));
    }

    public function update($id, $threadid)
    {
        $value = $this->threadRepo->showThread($threadid);

        $value->user_id = Session::get('user_id');
        $value->title = Session::get('title');
        $value->tag_id = Session::get('tag_id');
        $value->forum_id = Session::get('forum_id');
        $value->detail = Session::get('detail');
        $value->status = Session::get('status');
        $value->thumbnail  = Session::get('thumbnail');

        $value->update();
        $value->notify(new EditThreadNotification());

        return redirect()->route('thread.show', $id);
    }



    public function show($id, $threadid)
    {
        $thread = $this->threadRepo->getThread($threadid);

        $value = $this->threadRepo->showThread($threadid);


        $user = $this->userRepo->showUser($value->user_id);

        $tag = $this->tagRepo->getTag($value->tag_id);

        $notifications = $this->notiRepo->showUnread();

        $profile = $this->profileRepo->getProfile(Auth::user()->id);

        $follower = $this->followRepo->showfollowerThread(Auth::user()->id,$value->id);
        
        return view('confirms.Thread.index', compact('thread', 'user', 'tag', 'notifications', 'profile','follower'));
    }



    public function destroy($id, $threadid)
    {

        $this->threadRepo->deleteThreads($threadid);
        $thread = $this->threadRepo->getTrash($threadid);
        $thread->notify(new DeleteThreadNotification());

        return redirect()->route('thread.show', $id);
    }

    public function restore($id, $threadid)
    {

        $this->threadRepo->restoreThreads($threadid);
        $thread = $this->threadRepo->showThread($threadid);
        $thread->notify(new RestoreThreadNotification());
        return redirect()->route('thread.show', $id);
    }


    public function all()
    {
        $threads = $this->threadRepo->allThreads();
        $notifications = $this->notiRepo->showUnread();

        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.export.threads.export_threads', compact('threads','notifications','profile'));
    }

    public function export()
    {
        return Excel::download(new ThreadsExport, 'threads_list.csv');
    }

    public function import(Request $request)
    {

        $file = $request->file('excel');
        Excel::import(new ThreadsImport, $file);
    }

    public function follow($userid,$threadid)
    {

        $thread = $this->threadRepo->showThread($threadid);
        $user = $this->userRepo->showUser($userid);
        
        $user->following()->attach($thread);
        $thread->notify(new GetFollowThreadNotfication());
       
        return redirect()->back();
    }

    public function unfollow($userid,$threadid)
    {

        $thread = $this->threadRepo->showThread($threadid);
        $user = $this->userRepo->showUser($userid);
        
        $user->following()->detach($thread);
        $thread->notify(new GetunFollowThreadNotfication());
       
        return redirect()->back();
    }
}
