<?php

namespace App\Http\Controllers;


use App\Models\Community;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\StoreCommunity;

use App\Notifications\Community\AddCommunityNotification;
use App\Notifications\Community\EditCommunityNotification;
use App\Notifications\Community\DeleteCommunityNotification;
use App\Notifications\Community\RestoreCommunityNotification;

use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Community\CommunityRepositoryInterface;

class CommunityController extends Controller
{
    protected $commuRepo;
    protected $postRepo;
    protected $userRepo;
    protected $commRepo;

    public function __construct(CommunityRepositoryInterface $commuRepo, PostRepositoryInterface $postRepo, UserRepositoryInterface $userRepo, CommentRepositoryInterface $commRepo)
    {
        $this->middleware('auth');
        $this->commuRepo = $commuRepo;
        $this->postRepo = $postRepo;
        $this->userRepo = $userRepo;
        $this->commRepo = $commRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $communities = $this->commuRepo->showall();
        $notifications = DB::table('notifications')->get()->where('read_at', '==', NULL);
        return view('confirms.Community.homepage', compact('communities', 'notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notifications = DB::table('notifications')->get()->where('read_at', '==', NULL);
        return view('confirms.Community.add_community', compact('notifications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommunity $request)
    {
        $data = $request->validated();

        $community = new Community;

        $community->title = $data['title'];
        if ($request->hasFile('banner')) {

            $community->banner = $request->file('banner');

            $extension = $community->banner->getClientOriginalExtension();
            $filename = $data['title'] . '.' . $extension;
            $path = storage_path('app/public/community/' . $data['title'] . '/');

            $community->banner->move($path, $filename);
        }
        $data['banner'] = $filename;

        $community->banner = $data['banner'];

        $community->save();
        $community->notify(new AddCommunityNotification());
        return redirect()->route('community.homepage');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $community = $this->commuRepo->showcommunity($id);
        $posts = $this->postRepo->showall($community->id);

        $notifications = DB::table('notifications')->get()->where('read_at', '==', NULL);

        return view('confirms.Community.index', compact('community', 'posts', 'notifications'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $community = $this->commuRepo->showcommunity($id);
        $notifications = DB::table('notifications')->get()->where('read_at', '==', NULL);
        return view('confirms.Community.edit_community', compact('community', 'notifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCommunity $request, $id)
    {
        $data = $request->validated();

        $community = $this->commuRepo->showcommunity($id);

        $community->title = $data['title'];

        $old_banner = $community->banner;

        if ($request->hasFile('banner')) {

            $community->banner =  $data['banner'];

            $extension =  $community->banner->getClientOriginalExtension();


            $filename =  $data['title'] . '.' . $extension;

            $path = storage_path('app/public/community/' . $data['title'] . '/');

            if (!file_exists($path . $filename)) {

                $community->banner->move($path, $filename);
            } else if (!file_exists($path . $old_banner)) {

                $community->banner->move($path, $filename);
            } else {

                unlink($path . $old_banner);
                $community->banner->move($path, $filename);
            }
        }
        $community->banner = $filename;
        $community->update();
        $community->notify(new EditCommunityNotification);
        return redirect()->route('community.homepage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
  
        $this->commuRepo->deletecommunity($id);
        $community = $this->commuRepo->getTrash($id);
        $community->notify(new DeleteCommunityNotification());
        return redirect()->back();
    }

    public function restore($id)
    {

        $this->commuRepo->restorecommunity($id);
        $community = $this->commuRepo->showcommunity($id);
        $community->notify(new RestoreCommunityNotification());
        return redirect()->back();
    }
}
