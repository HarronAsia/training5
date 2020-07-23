<?php

namespace App\Http\Controllers;

use Excel;

use App\Exports\UsersExport;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;

use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\User\Account\ProfileRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;


class UserController extends Controller
{

    protected $userRepo;

    protected $profileRepo;
    protected $notiRepo;


    public function __construct(UserRepositoryInterface $userRepo, ProfileRepositoryInterface $profileRepo, NotificationRepositoryInterface $notiRepo)

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
    public function show($name, $id)
    {

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        $user = $this->userRepo->showUser($id);
        return view('confirms.User.profile', compact('user', 'notifications','profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($name, $id)
    {
        $user = $this->userRepo->showUser($id);
        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.User.edit', compact('user', 'notifications','profile'));
    }

    public function confirm(StoreUser $request, $id)
    {

        $data = $request->validated();

        $value = $this->userRepo->showUser($id);

        Session::put('name', $data['name']);
        Session::put('email', $value->email);
        Session::put('password', $value->password);
        Session::put('dob', $data['dob']);
        Session::put('number', $data['number']);

        if ($request->hasFile('photo')) {

            $file = $request->file('photo');

            $extension = $file->getClientOriginalExtension();
            $filename =  Session::get('name') . '.' . $extension;

            $path = storage_path('app/public/' . Session::get('name') . '/');

            $file->move($path, $filename);
        }
        $data['photo'] = $filename;
        Session::put('photo', $data['photo']);

        $user = $value = Session::all();

        $notifications = $this->notiRepo->showUnread();
        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('confirms.User.confirm_page', compact('user','profile','notifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {

        $user = $this->userRepo->showUser($id);

        $user->name = Session::get('name');
        $user->email = Session::get('email');
        $user->password = Session::get('password');
        $user->dob = Session::get('dob');
        $user->photo = Session::get('photo');
        $user->number = Session::get('number');


        $user->update();

        return redirect()->route('profile.index',[$user->name,$user->id]);
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

    public function all()
    {
        $users = $this->userRepo->allUsers();
        $notifications = $this->notiRepo->showUnread();

        $profile = $this->profileRepo->getProfile(Auth::user()->id);
        return view('admin.export.users.export_users', compact('users','notifications','profile'));
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users_list.csv');
    }
}
