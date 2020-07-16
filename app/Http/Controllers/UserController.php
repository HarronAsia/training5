<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use App\Repositories\User\UserRepositoryInterface;

use App\User;
use App\Exports\UsersExport;
use Excel;

use Illuminate\Support\Facades\Session;

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
    public function show($id)
    {
        $user = $this->userRepo->showUser($id);

        return view('confirms.User.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepo->showUser($id);
        return view('confirms.User.edit', compact('user'));
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
