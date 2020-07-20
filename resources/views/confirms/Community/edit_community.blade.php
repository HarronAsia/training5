@extends('layouts.app')

@section('content')
@if(Auth::user()->role != 'admin')

@else
<div class="container-fluid">
    <div class="row">
        <!-- Edit thread Page -->
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

        <form action="{{route('admin.community.update',['id' => $community->id])}}" method="POST" enctype="multipart/form-data">
            
            @csrf

            <div class="form-group">
                <label for="banner">Upload Your Banner</label>
                <div>
                    <img src="{{asset('storage/community/'.$community->title.'/'.$community->banner.'/')}}" alt="Image" style="max-width: 500px ; max-height:500px;">
                    &nbsp;&nbsp;<i class="fa fa-arrow-right" style="font-size:48px;"></i>&nbsp;&nbsp;
                    <img id="image_preview_container" src="#" alt="preview image" style="max-width: 500px ; max-height:500px;">
                </div>
                <input type="file" class="form-control" name="banner" id="banner">
            </div>

            <div class="form-group">
                <label for="title">Edit thread Title</label>
                <input class="form-control" name="title" placeholder="Enter Your title" value="{{ $community->title}}">
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <!--Edit thread Page -->
    </div>
</div>

@endif

@endsection