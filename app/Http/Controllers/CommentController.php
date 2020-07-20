<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreComment;
use App\Post;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;

class CommentController extends Controller
{
    protected $postRepo;
    protected $commRepo;

    public function __construct(PostRepositoryInterface $postRepo, CommentRepositoryInterface $commRepo)
    {
        $this->middleware('auth');
        $this->postRepo = $postRepo;
        $this->commRepo = $commRepo;
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComment $request, $id)
    {
        $data = $request->validated();
        
        $post = $this->postRepo->showpost($id);
        
        if ($request->hasFile('comment_image')) {

            $data['comment_image'] = $request->file('comment_image');

            $extension = $data['comment_image']->getClientOriginalExtension();
            $filename = Auth::user()->id . '.' . $extension;
            $path = storage_path('app/public/comment/' . Auth::user()->id . '/');

            $data['comment_image']->move($path, $filename);
        }
        $data['comment_image'] = $filename;
        


        $post->comments()->create(['comment_detail' => $data['comment_detail'],
                                    'comment_image' =>  $data['comment_image'],
                                      'user_id' => Auth::user()->id]);

        return redirect()->route('community.show',$post->community_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($postid,$commentid)
    {
        $post = $this->postRepo->showpost($postid);
        $comment = $this->commRepo->showComment($commentid);
        return view('confirms.Comment.edit',compact('comment','post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreComment $request, $postid, $commentid)
    {
        $data = $request->validated();
        $post = $this->postRepo->showpost($postid);
        $comment = $this->commRepo->showComment($commentid);
        $old_image = $comment->comment_image;

        if ($request->hasFile('comment_image')) {

            $comment->comment_image =  $data['comment_image'];
            
            $extension =  $comment->comment_image->getClientOriginalExtension();
            
            
            $filename =  Auth::user()->id . '.' . $extension;
            
            $path = storage_path('app/public/community/' . Auth::user()->id . '/');
            
            if (!file_exists($path . $filename)) {

                $comment->comment_image->move($path, $filename);
            } else if (!file_exists($path . $old_image)) {

                $comment->comment_image->move($path, $filename);
            } else {

                unlink($path . $old_image);
                $comment->comment_image->move($path, $filename);
            }
        }
        $comment->comment_image = $filename;
        $comment->comment_detail = $data['comment_detail'];
        $comment->user_id = Auth::user()->id;

        $comment->update();

        return redirect()->route('community.show',$post->community_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($postid, $commentid)
    {
        $post = $this->postRepo->showpost($postid);
        $this->commRepo->deletecomment($commentid);
        return redirect()->route('community.show',$post->community_id);
    }

    public function restore($postid, $commentid)
    {
        $post = $this->postRepo->showpost($postid);
        $this->commRepo->restorecomment($commentid);
        return redirect()->route('community.show',$post->community_id);
    }
}
