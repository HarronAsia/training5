<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;

use App\Models\User;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\StoreAdmin;
use Illuminate\Support\Facades\Session;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\AdminPanel::class;
    }

    //*===============Count=============================*//
    public function countAllUsers()
    {
        return $this->model->users = DB::table('users')->where('role','"member"')->count();
    }

    public function countAllManagers()
    {
        return $this->model->managers = DB::table('users')->where('role','"manager"')->count();
    }

    public function countAllAdmins()
    {
        return $this->model->admins = DB::table('users')->where('role','"admin"')->count();
    }

    public function countAllThreadsByManager()
    {
        return $this->model->managers_threads = DB::table('threads')->join('users', 'user_id', '=', 'users.id')->get()->where('role', '"manager"')->count();
    }
    
    public function countAllThreadsByAdmin()
    {
        return $this->model->admins_threads = DB::table('threads')->join('users', 'user_id', '=', 'users.id')->get()->where('role', '"admin"')->count();
    }

    public function countAllTags()
    {
        return $this->model->tags = DB::table('tags')->get()->count();
    }

    public function countAllForums()
    {
        return $this->model->forums = DB::table('forums')->get()->count();
    }

    public function countAllCategories()
    {
        return $this->model->categories = DB::table('categories')->get()->count();
    }

    public function countAllCommunities()
    {
        return $this->model->communities = DB::table('communities')->get()->count();
    }

    public function countAllPosts()
    {
        return $this->model->posts = DB::table('posts')->get()->count();
    }

    public function countAllComments()
    {
        return $this->model->comments = DB::table('comments')->get()->count();
    }

    public function countAllReports()
    {
        return $this->model->comments = DB::table('reports')->get()->count();
    }

    public function countAllNotifications()
    {
        return $this->model->comments = DB::table('notifications')->get()->count();
    }

    //*===============Count =============================*//


    //*===============For User=============================*//
    public function getAllUsers()
    {
        return $this->model = DB::table('users')->where('role', '=', 'member"')->paginate(10);
    }

    //*===============For User=============================*//


    //*===============For Manager=============================*//
    public function getAllManagers()
    {
        return $users = DB::table('users')->where('role', '=', '"manager"')->paginate(10);
    }

    //*===============For Manager=============================*//


    //*===============For ADmin=============================*//
    public function getAllAdmins()
    {
        return $users = DB::table('users')->where('role', '=', '"admin"')->paginate(10);
    }

    //*===============For Admin=============================*//


    //*===============Main Edit=============================*//

    public function findAccount($id)
    {
        //dd($this->model = User::findOrFail($id));
        return $this->model = User::findOrFail($id);
        
    }
    public function confirmAdmin(StoreAdmin $request, $id)
    {
        $data = $request->validated();
       
        $this->model = User::where('id', '=', $id)->first();
        
        Session::put('id', $this->model->id);
        Session::put('name', $data['name']);
        Session::put('email',  $data['email']);
        Session::put('password',  $data['password']);
        Session::put('role',  $data['role']);
        Session::put('dob', $data['dob']);
        Session::put('number', $data['number']);
        Session::put('created_at', $this->model->created_at);
        Session::put('updated_at', $this->model->updated_at);
        


        $file = $request->file('photo');

        $extension = $file->getClientOriginalExtension();
        $filename =  Session::get('name') . '.' . $extension;

        $path = storage_path('app/public/' . Session::get('name') . '/');

        $file->move($path, $filename);

        $data['photo'] = $filename;
        Session::put('photo', $data['photo']);
        
        return $this->model = Session::all();
    }

    //*===============Main Edit=============================*//

    public function editforAdmin($id)
    {
        $this->model = User::where('id', '=', $id)->first();

        $this->model->id = Session::get('id');
        $this->model->name = Session::get('name');
        $this->model->email = Session::get('email');
        $password = Session::get('password');
        $this->model->password = hash('sha256',$password);
        $this->model->dob = Session::get('dob');
        $this->model->photo = Session::get('photo');
        $this->model->number = Session::get('number');
        $this->model->role = Session::get('role');
        $this->model->created_at = Session::get('created_at');
        $this->model->updated_at = Session::get('updated_at');
        //dd($this->model);

        return $this->model->update();
    }
}
