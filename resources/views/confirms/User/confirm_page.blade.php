@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Profile Page -->
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

        <form action="{{ route('profile.edit', ['id' => Auth::user()->id ])}} " method="POST" enctype="multipart/form-data" id="editprofile">
            @csrf

            <div class="form-group">
                <label for="name">User Name</label>
                <div>{{$user['name']}}</div>
            </div>

            <div class="form-group">
                <label for="dob">User Date Of Birth</label>
                <div>{{$user['dob']}}</div>
            </div>

            <div class="form-group">
                <label for="number">User Phone Number</label>
                <div>{{$user['number']}}</div>
            </div>

            <div class="form-group">
                <div>
                    <label for="photo">User Avatar</label>
                    <div>
                        <img src="{{asset('storage/'.$user['name'].'/'.$user['photo'])}}" alt="preview image" style="max-width: 500px ; max-height:500px;">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-default" id="editprofilebtn">Submit</button>
        </form>

        <!-- Profile Page -->
    </div>
</div>

@endsection