@extends('layouts.app')

@section('content')
@if(Auth::user()->role == 'admin')
<div class="container-fluid">
    <div class="row">
        <!-- Edit thread Page -->
        
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

        <form action="{{ route('admin.thread.update.confirm', ['id' => $forum->id ,'threadid' =>$thread->id])}}" method="POST" enctype="multipart/form-data" class="submit-to-confirm-thread">

            @csrf

            <div class="form-group">

                <input type="hidden" name="id" value="{{$thread->id}}">
            </div>
            <div class="form-group">

                <input type="hidden" name="user_id" value="{{$thread->user_id}}">
            </div>
            <div class="form-group">

                <input type="hidden" name="forum_id" value="{{$thread->forum_id}}">

            </div>

            <div class="form-group">
                <label for="thumbnail">Upload Your Image</label>
                <div>
                    <img src="{{asset('storage/thread/'.$thread->title.'/'.$thread->thumbnail.'/')}}" alt="Image" style="max-width: 500px ; max-height:500px;">
                    &nbsp;&nbsp;<i class="fa fa-arrow-right" style="font-size:48px;"></i>&nbsp;&nbsp;
                    <img id="image_preview_container" src="#" alt="preview image" style="max-width: 500px ; max-height:500px;">
                </div>
                <input type="file" class="form-control" name="thumbnail" id="thumbnail">
            </div>

            <div class="form-group">
                <label for="title">Edit thread Title</label>
                <input class="form-control" name="title" placeholder="Enter Your title" value="{{ $thread->title}}">
            </div>

            <div class="form-group">
                <label for="detail">Edit thread Detail</label>
                <input class="form-control" name="detail" placeholder="Enter Your detail" value="{{ $thread->detail}}">
            </div>

            <div class="form-group">
                <label for="tag_id" class="col-md-4 control-label">Tag ( Current) : {{ucfirst(trans($threadtag->name))}}</label>
                <select class="form-control" name="tag_id" id="tag_id">
                    @foreach($tags as $tag)
                    <option value="{{$tag->id}}">{{ucfirst(trans($tag->name))}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="status" class="col-md-4 control-label">Status:</label>
                <select class="form-control" name="status" id="status">
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                </select>
            </div>

            <button type="submit" class="btn btn-default confirm-thread">Submit</button>
        </form>
        <!--Edit thread Page -->
    </div>
</div>
@else
@if(Auth::user()->id != $thread->user_id)

@else
<div class="container-fluid">
    <div class="row">
        <!-- Edit thread Page -->
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

        <form action="{{ route('manager.thread.update.confirm', ['id' => $forum->id ,'threadid' =>$thread->id])}} " method="POST" enctype="multipart/form-data" id="edit_thread">

            @csrf

            <input type="hidden" name="id" value="{{$thread->id}}">
            <input type="hidden" name="user_id" value="{{$thread->user_id}}">
            <input type="hidden" name="forum_id" value="{{$thread->forum_id}}">

            <div class="form-group">
                <label for="thumbnail">Upload Your Image</label>
                <div>
                    <img src="{{asset('storage/thread/'.$thread->title.'/'.$thread->thumbnail.'/')}}" alt="Image" style="max-width: 500px ; max-height:500px;">
                    &nbsp;&nbsp;<i class="fa fa-arrow-right" style="font-size:48px;"></i>&nbsp;&nbsp;
                    <img id="image_preview_container" src="#" alt="preview image" style="max-width: 500px ; max-height:500px;">
                </div>
                <input type="file" class="form-control" name="thumbnail" id="thumbnail">
            </div>

            <div class="form-group">
                <label for="title">Edit thread Title</label>
                <input class="form-control" name="title" placeholder="Enter Your title" value="{{ $thread->title}}">
            </div>

            <div class="form-group">
                <label for="detail">Edit thread Detail</label>
                <input class="form-control" name="detail" placeholder="Enter Your detail" value="{{ $thread->detail}}">
            </div>

            <div class="form-group">
                <label for="tag_id" class="col-md-4 control-label">Tag ( Current) : {{ucfirst(trans($threadtag->name))}}</label>
                <select class="form-control" name="tag_id" id="tag_id">
                    @foreach($tags as $tag)
                    <option value="{{$tag->id}}">{{ucfirst(trans($tag->name))}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="status" class="col-md-4 control-label">Status:</label>
                <select class="form-control" name="status" id="status">
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                </select>
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <!--Edit thread Page -->
    </div>
</div>
@endif
@endif

@endsection