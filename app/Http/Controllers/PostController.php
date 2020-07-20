<?php

namespace App\Http\Controllers;

use App\Post;
use App\Community;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\Auth;

use App\Repositories\Community\CommunityRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    
    protected $commuRepo;
    protected $postRepo;
    protected $userRepo;

    public function __construct(CommunityRepositoryInterface $commuRepo, PostRepositoryInterface $postRepo, UserRepositoryInterface $userRepo)
    {
        $this->middleware('auth');
        $this->postRepo = $postRepo;
        $this->commuRepo = $commuRepo;
        $this->userRepo = $userRepo;
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
    public function store(StorePost $request, $id)
    {

        $data = $request->validated();

        $post = new Post();

        $community = Community::findOrFail($id);
        $data['community_id'] = $community->id;

        $data['user_id'] = Auth::user()->id;

        if ($request->hasFile('image')) {

            $post->image = $request->file('image');

            $extension = $post->image->getClientOriginalExtension();
            $filename = $data['user_id'] . '.' . $extension;
            $path = storage_path('app/public/post/' . $data['user_id'] . '/');
            
            $post->image->move($path, $filename);
        }
        $data['image'] = $filename;

        $post->detail = $data['detail'];
        $post->image = $data['image'];
        $post->user_id = $data['user_id'];
        $post->community_id = $data['community_id'];

        $post->save();

        
        return redirect()->route('community.show',$community->id);
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
    public function edit($id,$postid)
    {
        $community = $this->commuRepo->showcommunity($id);

        $post = $this->postRepo->showpost($postid);
        return view('confirms.Community.Post.edit',compact('post','community'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id, $postid)
    {
        $data = $request->validated();
        
        $post = $this->postRepo->showpost($postid);

        $post->detail = $data['detail'];

        $old_image = $post->image;

        if ($request->hasFile('image')) {

            $post->image =  $data['image'];
            
            $extension =  $post->image->getClientOriginalExtension();
            
            
            $filename =  $post->user_id . '.' . $extension;
            
            $path = storage_path('app/public/post/' . $post->user_id . '/');
            
            if (!file_exists($path . $filename)) {

                $post->image->move($path, $filename);
            } else if (!file_exists($path . $old_image)) {

                $post->image->move($path, $filename);
            } else {

                unlink($path . $old_image);
                $post->image->move($path, $filename);
            }
        }
        $post->image = $filename;
        
        $post->update();

        return redirect()->route('community.show',$post->community_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $postid)
    {        
        
        $community = $this->commuRepo->showcommunity($id);

        $this->postRepo->deletepost($postid);
        return redirect()->route('community.show',$community->id);
    }

    public function restore($id, $postid)
    {      
        $this->postRepo->restorepost($postid);
        $post = $this->postRepo->showpost($postid);
        return redirect()->route('community.show',$post->community_id);
    }
}
