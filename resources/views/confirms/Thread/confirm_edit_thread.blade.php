@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        <h1>WELCOME {{Auth::user()->name}}</h1>

        <h3>Let's review and confirm your thread before add to the website</h3>

        <h3 style="color: red;"><b>Don't worry the information here can only be seen by you !</b></h3>

        <h4 align="center">Confirmation page</h4>
        <div>
            <h5>Title</h5>
            <p>
                {{$thread['title']}}
            </p>
        </div>
        <div>
            <h5>Detail</h5>
            <p>
            {{$thread['detail']}}
            </p>
        </div>
        <div>
            <h5>Banner</h5>
            <p>
                <img src="{{asset('storage/thread/'.$thread['title'].'/'.$thread['thumbnail'])}}" alt="preview image" style="max-width: 500px ; max-height:500px;">
            </p>
        </div>
        <div>
            <h5>Tag</h5>
            <p>
                {{$tag->name}}
            </p>
        </div>
        <div>
            <h5>Status</h5>
            <p>
            {{$thread['status']}}
            </p>
        </div>
       
    </div>
</div>
 <!-- SUbmit Form -->
 @if(Auth::user()->role == "manager")
        <form action="{{ route('manager.thread.update', ['id' => $forum->id ,'threadid' =>$thread['id']])}}" method="POST" enctype="multipart/form-data" align="center">
            @else
            <form action="{{ route('admin.thread.update', ['id' => $forum->id ,'threadid' =>$thread['id']])}}" method="POST" enctype="multipart/form-data" align="center">
                @endif
                
                @csrf
                
                    <input type="hidden" name="id" value="{{$thread['id']}}">
                               
                    <input type="hidden" name="user_id" value="{{$thread['user_id']}}">
                
                    <input type="hidden" name="forum_id" value="{{$thread['forum_id']}}">
                              
                    <input type="hidden" name="title" value="{{$thread['title']}}">
                             
                    <input type="hidden" name="detail" value="{{$thread['detail']}}">
                             
                    <input type="hidden" name="thumbnail" value="{{$thread['thumbnail']}}">
                            
                    <input type="hidden" name="tag_id" value="{{$thread['tag_id']}}">
                            
                    <input type="hidden" name="status" value="{{$thread['status']}}">
                
                <button type="submit" class="btn btn-default">Submit</button>

                @if(Auth::user()->role == "manager")
            </form>
            @else
        </form>
        @endif
        <!-- SUbmit Form -->
@endsection