<?php

namespace App\Http\Controllers;

use Excel;

use App\User;
use App\Thread;
use App\Forum;

use Illuminate\Http\Request;
use App\Exports\ThreadsExport;

use App\Imports\ThreadsImport;
use App\Http\Requests\StoreThread;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;
use App\Repositories\Thread\ThreadRepositoryInterface;
use App\Repositories\Thread\Tag\TagRepositoryInterface;
use App\Repositories\Forum\ForumRepositoryInterface;
class ThreadController extends Controller
{
    protected $threadRepo;
    protected $tagRepo;
    protected $forumRepo;

    public function __construct(ThreadRepositoryInterface $threadRepo, TagRepositoryInterface $tagRepo,ForumRepositoryInterface $forumRepo)
    {
        $this->threadRepo = $threadRepo;
        $this->tagRepo = $tagRepo;
        $this->forumRepo = $forumRepo;
    }

    public function index($id)
    {
        if (Auth::user()->role == 'manager') {
            $forum = $this->forumRepo->showforum($id);
            
            $threads = $this->threadRepo->getallThreads($forum->id);
            return view('confirms.Forum.Thread.homepage', compact('threads','forum'));
        } else {
            $forum = $this->forumRepo->showforum($id);
            
            $threads = $this->threadRepo->getallThreadsforAdmin($forum->id);
            
            return view('confirms.Forum.Thread.homepage', compact('threads','forum'));
        }
    }

    public function create($id)
    {
        $forum = Forum::findOrFail($id);
        $threads = $this->threadRepo->addThread();
        $tags = $this->tagRepo->showall();

        return view('confirms.Thread.add_thread', compact('threads', 'tags', 'forum'));
    }

    //Confirm Add thread---------------------------------------------------------------
    public function confirmadd(StoreThread $request, $id)
    {

        $data = $request->validated();
        $value = new Thread();

        $forum = Forum::findOrFail($id);
        $value->forum_id = $forum->id;

        $data['user_id'] = Auth::user()->id;

        $tag = $this->tagRepo->getTag($data['tag_id']);
        if ($request->hasFile('thumbnail')) {

            $value->thumbnail = $request->file('thumbnail');

            $extension = $value->thumbnail->getClientOriginalExtension();
            $filename = $data['title'] . '.' . $extension;
            $path = storage_path('app/public/thread/' . $data['title'] . '/');

            $value->thumbnail->move($path, $filename);
        }
        $data['thumbnail'] = $filename;
        Session::put('tag_id', $data['tag_id']);
        Session::put('user_id', $data['user_id']);
        Session::put('forum_id', $forum->id);
        Session::put('title', $data['title']);
        Session::put('detail', $data['detail']);
        Session::put('status', $data['status']);

        Session::put('thumbnail', $data['thumbnail']);

        $thread = $value = Session::all();

        return view('confirms.Thread.confirm_add_thread', compact('thread', 'tag', 'forum'));
    }
    //Confirm Add thread-------------------------------------------------------------

    public function store($id)
    {
        $thread = new Thread();

        $thread->user_id = Session::get('user_id');
        $thread->title = Session::get('title');
        $thread->detail = Session::get('detail');
        $thread->status = Session::get('status');
        $thread->tag_id = Session::get('tag_id');
        $thread->forum_id = Session::get('forum_id');
        $thread->thumbnail  = Session::get('thumbnail');

        $thread->save();

        if (Auth::user()->role == 'manager') {
            $forum = Forum::findOrFail($id);
            $threads = $this->threadRepo->getallThreads($forum->id);
            return view('confirms.Forum.Thread.homepage', compact('threads', 'forum'));
        } else {
            $forum = Forum::findOrFail($id);
            $threads = $this->threadRepo->getallThreadsforAdmin($forum->id);
            return view('confirms.Forum.Thread.homepage', compact('threads', 'forum'));
        }
    }

    public function edit($id, $threadid)
    {
        $forum = Forum::findOrFail($id);
        $thread = $this->threadRepo->showThread($threadid);
        $tags = $this->tagRepo->showall();
        $threadtag = $this->tagRepo->getTag($thread->tag_id);
        return view('confirms.Thread.edit', compact('thread', 'tags', 'threadtag', 'forum'));
    }

    public function confirmupdate(StoreThread $request, $id, $threadid)
    {

        $data = $request->validated();
        $forum = Forum::findOrFail($id);
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

        return view('confirms.Thread.confirm_edit_thread', compact('thread', 'tag', 'forum'));
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

        if (Auth::user()->role == 'manager') {
            $forum = Forum::findOrFail($id);
            $threads = $this->threadRepo->getallThreads($forum->id);
            return view('confirms.Forum.Thread.homepage', compact('threads', 'forum'));
        } else {
            $forum = Forum::findOrFail($id);
            $threads = $this->threadRepo->getallThreadsforAdmin($forum->id);
            return view('confirms.Forum.Thread.homepage', compact('threads', 'forum'));
        }
    }



    public function show($id)
    {
        $thread = $this->threadRepo->showThread($id);

        $user = User::findOrFail($thread->user_id);

        $tag = $this->tagRepo->getTag($thread->tag_id);
        return view('confirms.Thread.index', compact('thread', 'user', 'tag'));
    }



    public function destroy($id, $threadid)
    {

        $this->threadRepo->deleteThreads($threadid);
        $forum = Forum::findOrFail($id);
        $threads = $this->threadRepo->getallThreadsforAdmin($forum->id);

        return view('confirms.Forum.Thread.homepage', compact('forum', 'threads'));
    }

    public function restore($id, $threadid)
    {

        $this->threadRepo->restoreThreads($threadid);

        $forum = Forum::findOrFail($id);
        
        $threads = $this->threadRepo->getallThreadsforAdmin($forum->id);
        return view('confirms.Forum.Thread.homepage', compact('forum', 'threads'));
    }


    public function all()
    {
        $threads = $this->threadRepo->allThreads();
        return view('admin.export.threads.export_threads', compact('threads'));
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
}
