<?php

namespace App\Http\Controllers;

use Excel;
use App\User;
use App\Exports\UsersExport;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use App\Repositories\User\UserRepositoryInterface;

class UserController extends Controller
{

    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
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
    public function show($name,$id)
    {
        
        $user = $this->userRepo->showUser($id);
        $notifications = DB::table('notifications')->get();
        return view('confirms.User.profile', compact('user','notifications'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($name,$id)
    {
        $user = $this->userRepo->showUser($id);
        $notifications = DB::table('notifications')->get();
        return view('confirms.User.edit', compact('user','notifications'));
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
        
        return view('confirms.User.confirm_page', compact('user'));
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
        
        $value = $this->userRepo->showUser($id);

        $value->name = Session::get('name');
        $value->email = Session::get('email');
        $value->password = Session::get('password');
        $value->dob = Session::get('dob');
        $value->photo = Session::get('photo');
        $value->number = Session::get('number');


        $value->update();

        return redirect('/');
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
        return view('admin.export.users.export_users', compact('users'));
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users_list.csv');
    }
}
