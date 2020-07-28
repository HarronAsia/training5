<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\Thread\ThreadRepositoryInterface;

class LikeController extends Controller
{

    protected $postRepo;
    protected $threadRepo;

    public function __construct(PostRepositoryInterface $postRepo, ThreadRepositoryInterface $threadRepo)
    {
        $this->middleware('auth');
        $this->postRepo = $postRepo;
        $this->threadRepo = $threadRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function like($postid)
    {
        $post = $this->postRepo->showpost($postid);

        $post->likes()->create([
            'user_id' => Auth::user()->id
        ]);

        if(Auth::user()->role == 'admin')
        {
            return redirect()->route('admin.community.show', [$post->community_id]);
        }
        elseif(Auth::user()->role == 'manager')
        {
            return redirect()->route('manager.community.show', [$post->community_id]);
        }
        else
        {
            return redirect()->route('member.community.show', [$post->community_id]);
        }
    }

    public function unlike($postid)
    {
        $post = $this->postRepo->showpost($postid);

        $post->likes()->delete();
       
        return redirect()->back();
    }

    public function likethread($threadid)
    {
        $thread = $this->threadRepo->showThread($threadid);

        $thread->likes()->create([
            'user_id' => Auth::user()->id
        ]);

        if(Auth::user()->role == 'admin')
        {
            return redirect()->route('admin.thread.detail', [$thread->forum_id, $thread->id]);
        }
        elseif(Auth::user()->role == 'manager')
        {
            return redirect()->route('manager.thread.detail', [$thread->forum_id, $thread->id]);
        }
        else
        {
            return redirect()->route('member.thread.detail', [$thread->forum_id, $thread->id]);
        }
    }

    public function unlikethread($threadid)
    {
        $thread = $this->threadRepo->showThread($threadid);

        $thread->likes()->delete();
       
        return redirect()->back();
    }
}
