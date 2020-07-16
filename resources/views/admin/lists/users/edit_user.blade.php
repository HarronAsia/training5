@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Profile Page -->
        <a href="javascript:history.back()" class="btn btn-primary">Back</a>
        <form action="/admin/member/{{$user->id}}/confirm " method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="photo">Change User Image</label>
                <div>
                    @if ($user->photo == NULL)
                    <img src="{{asset('storage/default.png')}}" alt="Image" style="width:200px ;height:200px;">
                    @else
                    <img src="{{asset('storage/'.$user->name.'/'.$user->photo)}}" alt="Image" style="width:200px ;height:200px;">
                    @endif
                    &nbsp;&nbsp;<i class="fa fa-arrow-right" style="font-size:48px;"></i>&nbsp;&nbsp;
                    <img id="image_preview_container" src="#" alt="preview Content Image" style="max-width: 500px ; max-height:500px;">

                    <input type="file" class="form-control" name="photo" id="photo">
                </div>
            </div>

            <div class="form-group">
                <label for="name">User name</label>
                <input class="form-control" name="name" placeholder="Enter User Name" value="{{ $user->name}}" required>
            </div>

            <div class="form-group">
                <label for="name">User email</label>
                <input class="form-control" name="email" placeholder="Enter User Name" value="{{ $user->email}}" required>
            </div>

            <div class="form-group">
                <label for="name">User password</label>
                <input class="form-control" name="password" placeholder="Enter User Name" value="{{ $user->password}}" required>
            </div>

            <div class="form-group">
                <label for="dob">User Birthday</label>
                <input type="date" class="form-control" name="dob" placeholder="Enter User DOB" value="{{ $user->dob }}" required>
            </div>

            <div class="form-group">
                <label for="number">User Phone Number</label>
                <input type="tel" class="form-control" name="number" placeholder="Enter User Phone Number" value="{{ $user->number }}" required>
            </div>

            <div class="form-group">
                <label for="role" class="col-md-4 control-label">User Type:</label>
                <select class="form-control" name="role" id="role">
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="member">Member</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </form>
        <!-- Profile Page -->
    </div>
</div>

@endsection