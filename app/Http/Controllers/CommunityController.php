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
use App\Notifications\Community\GetFollowCommunityNotfication;
use App\Notifications\Community\GetunFollowCommunityNotfication;

use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Community\CommunityRepositoryInterface;
use App\Repositories\User\Account\ProfileRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Follower\FollowerRepositoryInterface;

class CommunityController extends Controller
{
    protected $commuRepo;
    protected $postRepo;
    protected $userRepo;
    protected $commRepo;
    protected $profileRepo;
    protected $notiRepo;
    protected $followRepo;

    public function __construct(CommunityRepositoryInterface $commuRepo, PostRepositoryInterface $postRepo, UserRepositoryInterface $userRepo, 
    CommentRepositoryInterface $commRepo, ProfileRepositoryInterface $profileRepo, NotificationRepositoryInterface $notiRepo,FollowerRepositoryInterface $followRepo)
    {
        $this->middleware('auth');
        $this->commuRepo = $commuRepo;
        $this->postRepo = $postRepo;
        $this->userRepo = $userRepo;
        $this->commRepo = $commRepo;
        $this->profileRepo = $profileRepo;
        $this->notiRepo = $notiRepo;
        $this->followRepo = $followRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $communities = $this->commuRepo->showall();
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.Community.homepage', compact('communities', 'notifications', 'profile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notifications = DB::table('notifications')->get()->where('read_at', '==', NULL);
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.Community.add_community', compact('notifications','profile'));
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

        $notifications  = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);

        $follower = $this->followRepo->showfollowerThread(Auth::user()->id,$community->id);

        return view('confirms.Community.index', compact('community', 'posts', 'notifications','profile','follower'));
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
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.Community.edit_community', compact('community', 'notifications','profile'));
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

    public function follow($userid,$communityid)
    {

        $community = $this->commuRepo->showcommunity($communityid);
        $user = $this->userRepo->showUser($userid);
        
        $user->following()->attach($community);
        $community->notify(new GetFollowCommunityNotfication());
       
        return redirect()->back();
    }

    public function unfollow($userid,$communityid)
    {

        $community = $this->commuRepo->showcommunity($communityid);
        $user = $this->userRepo->showUser($userid);
        
        $user->following()->detach($community);
        $community->notify(new GetunFollowCommunityNotfication());
       
        return redirect()->back();
    }
}
