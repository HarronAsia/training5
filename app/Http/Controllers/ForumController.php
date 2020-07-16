<?php

namespace App\Http\Controllers;


use App\Forum;
use Illuminate\Http\Request;
use App\Http\Requests\StoreForum;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Thread\ThreadRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Forum\ForumRepositoryInterface;


class ForumController extends Controller
{
    protected $forumRepo;
    protected $cateRepo;
    protected $threadRepo;

    public function __construct(ThreadRepositoryInterface $threadRepo, CategoryRepositoryInterface $cateRepo, ForumRepositoryInterface $forumRepo)
    {
        $this->middleware('auth');
        $this->forumRepo = $forumRepo;
        $this->cateRepo = $cateRepo;
        $this->threadRepo = $threadRepo;
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
        return view('confirms.Forum.add_forum', compact('category'));
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

        $forums = $this->forumRepo->getForums($category->id);

        return view('confirms.Category.Forum.homepage', compact('category', 'forums'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $threadid)
    {

        if (Auth::user()->role == 'manager') {
            $forum = $this->forumRepo->showforum($id);
            $threads = $this->threadRepo->getallThreads($threadid);
            return view('confirms.Forum.Thread.homepage', compact('threads', 'forum'));
        } else {
            $forum = $this->forumRepo->showforum($id);
            $threads = $this->threadRepo->getallThreadsforAdmin($threadid);
            return view('confirms.Forum.Thread.homepage', compact('threads', 'forum'));
        }
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
        return view('confirms.Category.Forum.edit', compact('forum'));
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

        $category = $this->cateRepo->showcategory($forum->category_id);
        $forums = $this->forumRepo->getForums($category->id);
         return view('confirms.Category.Forum.homepage', compact('category', 'forums'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $forum = $this->forumRepo->showforum($id);
        $this->forumRepo->deleteForums($forum->id);
        
        $category = $this->cateRepo->showcategory($forum->category_id);
        $forums = $this->forumRepo->getForums($category->id);
         return view('confirms.Category.Forum.homepage', compact('category', 'forums'));
    }

    public function restore($id)
    {
        
        $this->forumRepo->restoreForums($id);
        
        $forum = $this->forumRepo->showforum( $id);
        
        $category = $this->cateRepo->showcategory($forum->category_id);
        
        $forums = $this->forumRepo->getForums($category->id);
        
         return view('confirms.Category.Forum.homepage', compact('category', 'forums'));
    }
    
}
