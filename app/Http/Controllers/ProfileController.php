<?php

namespace App\Http\Controllers;


use App\Models\Profile;
use Illuminate\Http\Request;

use App\Repositories\User\Account\ProfileRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

class ProfileController extends Controller
{

    protected $profileRepo;
    protected $userRepo;
    protected $notiRepo;

    public function __construct( UserRepositoryInterface $userRepo, ProfileRepositoryInterface $profileRepo, NotificationRepositoryInterface $notiRepo)
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->profileRepo = $profileRepo;
        $this->notiRepo = $notiRepo;
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
    public function create($id)
    {
        $user = $this->userRepo->showUser($id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile($user->id);

        return view('confirms.User.Profile.personal_information', compact('user','notifications','profile'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {

        $data = $request;
        $profile = new Profile();

        $user = $this->userRepo->showUser($id);

        $profile->user_id = $user->id;
        $profile->place = $data['place'];
        $profile->job = $data['job'];
        $profile->personal_id = $data['personal_id'];
        $profile->issued_date = $data['issued_date'];
        $profile->issued_by = $data['issued_by'];
        $profile->supervisor_name = $data['supervisor_name'];
        $profile->supervisor_dob = $data['supervisor_dob'];
        $profile->detail = $data['detail'];

        $profile->save();

        return redirect()->route('account.profile',$user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        
        
        $user = $this->userRepo->showUser($id);
        $profile = $this->profileRepo->getProfile($user->id);
        
        $notifications = $this->notiRepo->showUnread();
        return view('confirms.User.Profile.index', compact('profile', 'user','notifications'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = $this->profileRepo->getProfile($id);
        $user = $this->userRepo->showUser($id);
        $notifications = $this->notiRepo->showUnread();
        return view('confirms.User.Profile.edit', compact('profile', 'user','notifications'));
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
        $data = $request;
        $profile = $this->profileRepo->showProfile($id);
        
        $profile->place = $data['place'];
        $profile->job = $data['job'];
        $profile->personal_id = $data['personal_id'];
        $profile->issued_date = $data['issued_date'];
        $profile->issued_by = $data['issued_by'];
        $profile->supervisor_name = $data['supervisor_name'];
        $profile->supervisor_dob = $data['supervisor_dob'];
        $profile->detail = $data['detail'];
        $profile->google_plus_name = $data['google_plus_name'];
        $profile->google_plus_link = $data['google_plus_link'];
        $profile->aim_link = $data['aim_link'];
        $profile->icq_link = $data['icq_link'];
        $profile->window_live_link = $data['window_live_link'];
        $profile->yahoo_link = $data['yahoo_link'];
        $profile->skype_link = $data['skype_link'];
        $profile->google_talk_link = $data['google_talk_link'];
        $profile->facebook_link = $data['facebook_link'];
        $profile->twitter_link = $data['twitter_link'];
        
        $profile->update();

        return redirect()->route('account.profile',$profile->user_id);
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
}
