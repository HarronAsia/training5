@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <a href="javascript:history.back()" class="btn btn-primary">Back</a>
        <h1>WELCOME {{Auth::user()->name}}</h1>

        <h3>Let's review and confirm your edit before add to the website</h3>

        <h3 style="color: red;"><b>Don't worry the information here can only be seen by you !</b></h3>

        <h1 align="center">Confirmation page</h1>

        <form action="/admin/manager/{{$user['id']}}/update " method="POST" enctype="multipart/form-data" align="center">
            @csrf

            <div class="form-group">
                <label for="photo">Change Manager Image</label>
                <div>
                    <img src="{{asset('storage/'.$user['name'].'/'.$user['photo'])}}" alt="Image" style="max-width: 500px ; max-height:500px;">
                </div>
            </div>

            <div class="form-group">
                <label for="name">Manager name</label>
                <div>{{$user['name']}}</div>
            </div>

            <div class="form-group">
                <label for="email">Manager email</label>
                <div>{{$user['email']}}</div>
            </div>

            <div class="form-group">
                <label for="password">Manager password</label>
                <div>{{$user['password']}}</div>
            </div>

            <div class="form-group">
                <label for="dob">Manager Birthday</label>
                <div>{{$user['dob']}}</div>
            </div>

            <div class="form-group">
                <label for="number">Manager Phone Number</label>
                <div>{{$user['number']}}</div>
            </div>

            <div class="form-group">
                <label for="role" class="col-md-4 control-label">Manager Type:</label>
                <div>{{$user['role']}}</div>
            </div>

            <div class="form-group">
                <label for="created_at" class="col-md-4 control-label">Created At:</label>
                <div>{{$user['created_at']}}</div>
            </div>

            <div class="form-group">
                <label for="updated_at" class="col-md-4 control-label">Last Update:</label>
                <div>{{$user['updated_at']}}</div>
            </div>



            <div class="form-group">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection