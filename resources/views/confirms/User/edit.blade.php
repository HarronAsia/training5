@extends('layouts.app')

@section('content')
@if(Auth::user()->role == 'admin')
<div class="container-fluid">
    <div class="row">
        <!-- Profile Page -->
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

        <form action="{{ route('profile.edit.confirm', ['name' => Auth::user()->name,'id'=> Auth::user()->id])}} " method="POST" enctype="multipart/form-data" id="editprofile">
            @csrf

            <div class="form-group">
                @if ($user->photo == NULL)
                <img src="{{asset('storage/default.png')}}" alt="Image" style="width:200px ;height:200px;">
                @else
                <img src="{{asset('storage/'.$user->name.'/'.$user->photo)}}" alt="Image" style="width:200px ;height:200px;">
                @endif
                &nbsp;&nbsp;<i class="fa fa-arrow-right" style="font-size:48px;"></i>&nbsp;&nbsp;
                <img id="image_preview_container" src="#" alt="preview image" style="max-width: 500px ; max-height:500px;">
                <div>
                    <label for="photo">Your Image</label>
                    <input type="file" class="form-control" name="photo" id="photo" required>
                </div>
            </div>



            <div class="form-group">
                <label for="name">Your name</label>
                <input class="form-control" name="name" placeholder="Enter Your Name" value="{{ $user->name}}" required>
            </div>

            <div class="form-group">
                <label for="dob">Your Birthday</label>
                <input type="date" class="form-control" name="dob" placeholder="Enter Your DOB" value="{{ $user->dob }}" required>
            </div>

            <div class="form-group">
                <label for="number">Your Phone Number</label>
                <input type="tel" class="form-control" name="number" placeholder="Enter Your Phone Number" value="{{ $user->number }}" required>
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <!-- Profile Page -->
    </div>
</div>
@else
@if(Auth::user()->id != $user->id)


@else
<div class="container-fluid">
    <div class="row">
        <!-- Profile Page -->
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

        <form action="{{ route('profile.edit.confirm', ['name'=> Auth::user()->name,'id'=> Auth::user()->id])}} " method="POST" enctype="multipart/form-data" id="editprofile">
            @csrf

            <div class="form-group">
                @if ($user->photo == NULL)
                <img src="{{asset('storage/default.png')}}" alt="Image" style="width:200px ;height:200px;">
                @else
                <img src="{{asset('storage/'.$user->name.'/'.$user->photo)}}" alt="Image" style="width:200px ;height:200px;">
                @endif
                &nbsp;&nbsp;<i class="fa fa-arrow-right" style="font-size:48px;"></i>&nbsp;&nbsp;
                <img id="image_preview_container" src="#" alt="preview image" style="max-width: 500px ; max-height:500px;">
                <div>
                    <label for="photo">Your Image</label>
                    <input type="file" class="form-control" name="photo" id="photo" required>
                </div>
            </div>



            <div class="form-group">
                <label for="name">Your name</label>
                <input class="form-control" name="name" placeholder="Enter Your Name" value="{{ $user->name}}" required>
            </div>

            <div class="form-group">
                <label for="dob">Your Birthday</label>
                <input type="date" class="form-control" name="dob" placeholder="Enter Your DOB" value="{{ $user->dob }}" required>
            </div>

            <div class="form-group">
                <label for="number">Your Phone Number</label>
                <input type="tel" class="form-control" name="number" placeholder="Enter Your Phone Number" value="{{ $user->number }}" required>
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <!-- Profile Page -->
    </div>
</div>
@endif
@endif

@endsection