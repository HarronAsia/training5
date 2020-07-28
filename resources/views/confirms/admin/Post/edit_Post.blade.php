@extends('layouts.app')

@section('content')


<div class="container-fluid">
    <div class="row justify-content-center">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

        <form action="{{ route('posts.admin.update',['postid'=>$post->id])}}" method="POST" enctype="multipart/form-data">

            @csrf
            <div class="form-group">
                <input type="text" name="detail" class="form-control form-control-lg" placeholder="Enter Your thought" value="{{$post->detail}}" required>
            </div>

            <div class="form-group">
                <label for="image">Upload Your Image</label>
                <div>
                    <img src="{{asset('storage/post/'.$post->user_id.'/'.$post->image.'/')}}" alt="image" style="max-width: 500px ; max-height:500px;">
                    &nbsp;&nbsp;<i class="fa fa-arrow-right" style="font-size:48px;"></i>&nbsp;&nbsp;
                    <img id="image_preview_container" src="#" alt="preview image" style="max-width: 500px ; max-height:500px;">
                </div>
                <input type="file" class="form-control" name="image" id="image">
            </div>

            <div class="form-group">
                <input type="submit" class="form-control form-control-lg" class="btn btn-success btn-block btn-lg">
            </div>

        </form>

    </div>
</div>


@endsection