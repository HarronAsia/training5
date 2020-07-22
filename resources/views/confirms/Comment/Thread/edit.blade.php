@extends('layouts.app')

@section('content')
<a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
<div class="container-fluid">
    <div class="row justify-content-center">
        <form action="{{route('admin.comment.update.thread',['threadid' => $thread->id,'commentid'=>$comment->id])}}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label for="comment_image">Upload Your Comment image</label>
                <div>
                    <img src="{{asset('storage/thread/comment/'.$thread->title.'/'.$comment->comment_image)}}" alt="image" style="max-width: 500px ; max-height:500px;">
                    &nbsp;&nbsp;<i class="fa fa-arrow-right" style="font-size:48px;"></i>&nbsp;&nbsp;
                    <img id="image_preview_container2" src="#" alt="preview image" style="max-width: 500px ; max-height:500px;">
                </div>
                <input type="file" class="form-control" name="comment_image" id="comment_image">
            </div>

            <div class="form-group">
                <label for="title">Edit Comment detail</label>
                <input class="form-control" name="comment_detail" placeholder="Enter Your title" value="{{ $comment->comment_detail}}">
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</div>
@endsection