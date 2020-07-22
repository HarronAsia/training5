<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Profile;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{
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
        $user = User::findOrFail(Auth::user()->id);
       
        return view('confirms.User.Profile.personal_information',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $request;
        $profile = new Profile();
        $user = User::findOrFail(Auth::user()->id);
        $profile->user_id = Auth::user()->id;
        $profile->place = $data['place'];
        $profile->job = $data['job'];
        $profile->personal_id = $data['personal_id'];
        $profile->issued_date = $data['issued_date'];
        $profile->issued_by = $data['issued_by'];
        $profile->supervisor_name = $data['supervisor_name'];
        $profile->supervisor_dob = $data['supervisor_dob'];
        $profile->detail = $data['detail'];
        
        $profile->save();
        return view('confirms.User.Profile.index',compact('profile','user'));

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $profile = Profile::findOrFail($id);
       $user = User::findOrFail(Auth::user()->id) ;
       return view('confirms.User.Profile.index',compact('profile','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        $user = User::findOrFail(Auth::user()->id) ;
        return view('confirms.User.Profile.edit',compact('profile','user'));
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
        $profile = Profile::findOrFail($id);
        $user = User::findOrFail(Auth::user()->id) ;

        $profile->user_id = $user->id;
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
        return view('confirms.User.Profile.index',compact('profile','user'));
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
