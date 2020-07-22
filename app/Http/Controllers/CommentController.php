<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreComment;

use App\Notifications\AddCommentNotification;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Thread\ThreadRepositoryInterface;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notification;

class CommentController extends Controller
{
    protected $postRepo;
    protected $commRepo;
    protected $threadRepo;

    public function __construct(PostRepositoryInterface $postRepo, CommentRepositoryInterface $commRepo,ThreadRepositoryInterface $threadRepo)
    {
        $this->middleware('auth');
        $this->postRepo = $postRepo;
        $this->commRepo = $commRepo;
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
            $filename =  Auth::user()->name. '.' . $extension;
            $path = storage_path('app/public/comment/thread/' . $data['comment_detail'] . '/');

            $data['comment_image']->move($path, $filename);
        }
        $data['comment_image'] = $filename;
        


        $post->comments()->create(['comment_detail' => $data['comment_detail'],
                                    'comment_image' =>  $data['comment_image'],
                                      'user_id' => Auth::user()->id]);
        
        return redirect()->back();
    }

    public function store2(StoreComment $request, $id)
    {
        $data = $request->validated();
        
        $thread = $this->threadRepo->showThread($id);
        
        if ($request->hasFile('comment_image')) {

            $data['comment_image'] = $request->file('comment_image');

            $extension = $data['comment_image']->getClientOriginalExtension();
            $filename =  Auth::user()->name. '.' . $extension;
            $path = storage_path('app/public/comment/thread/' . $data['comment_detail'] . '/');

            $data['comment_image']->move($path, $filename);
        }
        $data['comment_image'] = $filename;
        


        $thread->comments()->create(['comment_detail' => $data['comment_detail'],
                                    'comment_image' =>  $data['comment_image'],
                                      'user_id' => Auth::user()->id]);
        
        return redirect()->back();
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
        $$notifications = DB::table('notifications')->get()->where('read_at','==',NULL);
        return view('confirms.Comment.edit',compact('comment','post','notifications'));
    }

    public function edit2($threadid,$commentid)
    {
        $thread = $this->threadRepo->showThread($threadid);
        $comment = $this->commRepo->showComment($commentid);
        $notifications = DB::table('notifications')->get()->where('read_at','==',NULL);
        return view('confirms.Comment.edit2',compact('comment','thread','notifications'));
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
            
            
            $filename =  Auth::user()->name . '.' . $extension;
            
            $path = storage_path('app/public/comment/post/' . $data['comment_detail'] . '/');
            
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

        $comment = $this->commRepo->showComment($comment->id);
  
        $comment->notify(new AddCommentNotification());
        
        if(Auth::user()->role == 'admin')
        {
            
            return redirect()->route('manager.community.show',[$post->community_id,$post->id]);
        }
        else
        {
            return redirect()->route('community.show',[$post->community_id,$post->id]);
        }
        
    }

    public function update2(StoreComment $request, $threadid, $commentid)
    {
        
        $data = $request->validated();
        $thread = $this->threadRepo->showThread($threadid);
        $comment = $this->commRepo->showComment($commentid);
        $old_image = $comment->comment_image;

        if ($request->hasFile('comment_image')) {

            $comment->comment_image =  $data['comment_image'];
          
            $extension =  $comment->comment_image->getClientOriginalExtension();
            
            
            $filename =  Auth::user()->name. '.' . $extension;
            
            $path = storage_path('app/public/comment/thread/' . $data['comment_detail'] . '/');
            
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

        $comment = $this->commRepo->showComment($comment->id);
        //dd( $comment);
        $comment->notify(new AddCommentNotification());
        
        return redirect()->route('thread.detail',[$thread->forum_id,$thread->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($postid, $commentid)
    {
        
        $this->commRepo->deletecomment($commentid);
        return redirect()->back();
    }

    public function restore($postid, $commentid)
    {
        
        $this->commRepo->restorecomment($commentid);
        return redirect()->back();
    }
}
