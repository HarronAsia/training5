<?php

namespace App\Http\Controllers;

use Excel;

use App\Models\Forum;
use App\Models\Thread;

use Illuminate\Http\Request;
use App\Exports\ThreadsExport;

use App\Imports\ThreadsImport;
use App\Http\Requests\StoreThread;
use Illuminate\Support\Facades\Auth;

use App\Notifications\For_ADMIN\Thread\AddThreadNotification;
use App\Notifications\For_ADMIN\Thread\EditThreadNotification;
use App\Notifications\For_ADMIN\Thread\DeleteThreadNotification;
use App\Notifications\For_ADMIN\Thread\RestoreThreadNotification;
use App\Notifications\For_ADMIN\Thread\GetFollowThreadNotfication;
use App\Notifications\For_ADMIN\Thread\GetunFollowThreadNotfication;



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

    public function __construct(
        ThreadRepositoryInterface $threadRepo,
        TagRepositoryInterface $tagRepo,
        ForumRepositoryInterface $forumRepo,
        CommentRepositoryInterface $commRepo,
        ProfileRepositoryInterface $profileRepo,
        NotificationRepositoryInterface $notiRepo,
        UserRepositoryInterface $userRepo,
        FollowerRepositoryInterface $followRepo
    ) {
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

    public function store(Request $request, $id)
    {
        
        $data = $request;
        $thread = new Thread();

        $thread->user_id = $data['user_id'];
        $thread->title = $data['title'];
        $thread->detail = $data['detail'];
        $thread->status = $data['status'];
        $thread->tag_id = $data['tag_id'];
        $thread->forum_id = $id;
        $thread->thumbnail  = $data['thumbnail'];
        
        $thread->save();
        $thread->notify(new AddThreadNotification());
        if(Auth::user()->role == 'manager')
        {
            return redirect()->route('manager.thread.show', $id);
        }
        elseif(Auth::user()->role == 'admin')
        {
            return redirect()->route('admin.thread.show', $id);
        }
        else
        {
            return redirect()->route('member.thread.show', $id);
        }
        
    }

    public function edit($id, $threadid)
    {
        
        $forum = $this->forumRepo->showforum($id);
        $thread = $this->threadRepo->showThread($threadid);
        if(Auth::user()->id != $thread->user_id)
        {
            return redirect()->route('member.thread.show', $forum->id);
        }
        else
        {
            $tags = $this->tagRepo->showall();
            $threadtag = $this->tagRepo->getTag($thread->tag_id);
    
            $notifications = $this->notiRepo->showUnread();
            $profile = $this->profileRepo->getProfile(Auth::user()->id);
            return view('confirms.Thread.edit', compact('thread', 'tags', 'threadtag', 'forum', 'notifications', 'profile'));
        }
       
    }

    public function confirmupdate(StoreThread $request, $id, $threadid)
    {

        $data = $request->validated();

        $forum = $this->forumRepo->showforum($id);

        $thread = $this->threadRepo->showThread($threadid);

        $tag = $this->tagRepo->getTag($data['tag_id']);

        $thread->tag_id = $data['tag_id'];
        $thread->forum_id = $forum->id;
        $thread->title = $data['title'];
        $thread->detail = $data['detail'];
        $thread->status = $data['status'];
        
        $old_thumbnail = $thread->thumbnail;

        if ($request->hasFile('thumbnail')) {

            $thread->thumbnail = $request->file('thumbnail');

            $extension = $data['thumbnail']->getClientOriginalExtension();
            $filename =  $data['title'] . '.' . $extension;

            $path = storage_path('app/public/thread/' . $data['title'] . '/');

            if (!file_exists($path . $filename)) {

                $thread->thumbnail->move($path, $filename);
            } else if (!file_exists($path . $old_thumbnail)) {

                $thread->thumbnail->move($path, $filename);
            } else {

                unlink($path . $old_thumbnail);
                $thread->thumbnail->move($path, $filename);
            }
        }
        $data['thumbnail'] = $filename;
        $thread->thumbnail = $data['thumbnail'];

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);

        return view('confirms.Thread.confirm_edit_thread', compact('thread', 'tag', 'forum', 'notifications', 'profile'));
    }

    public function update(Request $request,$id, $threadid)
    {
        
        $data = $request;
        
        $thread = $this->threadRepo->showThread($threadid);

        $thread->user_id = $data['user_id'];
        $thread->title = $data['title'];
        $thread->tag_id = $data['tag_id'];
        $thread->forum_id = $data['forum_id'];
        $thread->detail = $data['detail'];
        $thread->status = $data['status'];
        $thread->thumbnail  = $data['thumbnail'];

        $thread->update();
        $thread->notify(new EditThreadNotification());

        if(Auth::user()->role == 'manager')
        {
            return redirect()->route('manager.thread.show', $id);
        }
        else
        {
            return redirect()->route('admin.thread.show', $id);
        }
       
    }



    public function show($id, $threadid)
    {

        if (Auth::guest()) {
            $thread = $this->threadRepo->getThread($threadid);

            $value = $this->threadRepo->showThread($threadid);

            $user = $this->userRepo->showUser($value->user_id);

            $tag = $this->tagRepo->getTag($value->tag_id);
            return view('confirms.Thread.index', compact('thread', 'user', 'tag'));

        } else {
            $thread = $this->threadRepo->getThread($threadid);

            $value = $this->threadRepo->showThread($threadid);


            $user = $this->userRepo->showUser($value->user_id);

            $tag = $this->tagRepo->getTag($value->tag_id);

            $notifications = $this->notiRepo->showUnread();

            $profile = $this->profileRepo->getProfile(Auth::user()->id);

            $follower = $this->followRepo->showfollowerThread( Auth::user()->id,$value->id);
            //dd($follower);
            return view('confirms.Thread.index', compact('thread', 'user', 'tag', 'notifications', 'profile', 'follower'));
        }
    }



    public function destroy($id, $threadid)
    {

        $this->threadRepo->deleteThreads($threadid);
        $thread = $this->threadRepo->getTrash($threadid);
        $thread->notify(new DeleteThreadNotification());

        if(Auth::user()->role == 'manager')
        {
            return redirect()->route('manager.thread.show', $id);
        }
        else
        {
            return redirect()->route('admin.thread.show', $id);
        }
    }

    public function restore($id, $threadid)
    {

        $this->threadRepo->restoreThreads($threadid);
        $thread = $this->threadRepo->showThread($threadid);
        $thread->notify(new RestoreThreadNotification());
        return redirect()->route('admin.thread.show', $id);
    }


    public function all()
    {
        $threads = $this->threadRepo->allThreads();
        $notifications = $this->notiRepo->showUnread();

        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.export.threads.export_threads', compact('threads', 'notifications', 'profile'));
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

    public function follow($userid, $threadid)
    {

        $thread = $this->threadRepo->showThread($threadid);
        $user = $this->userRepo->showUser($userid);

        $user->following()->attach($thread);
        $thread->notify(new GetFollowThreadNotfication());

        return redirect()->back();
    }

    public function unfollow($userid, $threadid)
    {

        $thread = $this->threadRepo->showThread($threadid);
        $user = $this->userRepo->showUser($userid);

        $user->following()->detach($thread);
        $thread->notify(new GetunFollowThreadNotfication());

        return redirect()->back();
    }
}
