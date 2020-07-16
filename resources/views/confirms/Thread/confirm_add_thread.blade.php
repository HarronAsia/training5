@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        <h1>WELCOME {{Auth::user()->name}}</h1>

        <h3>Let's review and confirm your thread before add to the website</h3>

        <h3 style="color: red;"><b>Don't worry the information here can only be seen by you !</b></h3>

        <h1 align="center">Confirmation page</h1>

        
        <!-- SUbmit Form -->
        @if(Auth::user()->role == "manager")
        <form action="{{ route('manager.thread.create',['id' => $forum->id ])}}" method="POST" enctype="multipart/form-data" align="center">
            @else
            <form action="{{ route('admin.thread.create',['id' => $forum->id ])}}" method="POST" enctype="multipart/form-data" align="center">
                @endif

                @csrf
                <div class="form-group">
                    <label for="title">thread Title</label>
                    <div>{{$thread['title']}}</div>
                </div>

                <div class="form-group">
                    <label for="detail">thread Detail</label>
                    <div>{{$thread['detail']}}</div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="thumbnail">Upload Your Banner image</label>
                        <div>
                            <img src="{{asset('storage/thread/'.$thread['title'].'/'.$thread['thumbnail'])}}" alt="preview image" style="max-width: 500px ; max-height:500px;">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Tag</label>
                    <div>{{ucfirst(trans($tag->name))}}</div>
                </div>

                <div class="form-group">
                    <label for="status" >Status:</label>
                    <div>{{$thread['status']}}</div>
                </div>

                <div class="form-group">
                    <input type="submit" class="form-control form-control-lg" class="btn btn-success btn-block btn-lg">
                </div>
            </form>
            <!-- SUbmit Form -->
    </div>
</div>

@endsection