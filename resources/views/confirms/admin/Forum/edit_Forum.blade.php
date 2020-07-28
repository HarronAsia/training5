@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    @if(Auth::user()->role == 'admin')
    <div class="row justify-content-center">

        <form action="{{route('forums.admin.update',['forumid' => $forum->id])}} " method="POST" enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label for="title">Edit Title</label>
                <input type="text" class="form-control" name="title" placeholder="Enter Your title" value="{{$forum->title}}">
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
    @else
   
    @endif
</div>
@endsection