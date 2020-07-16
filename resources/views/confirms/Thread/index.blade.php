@extends('layouts.app')

@section('content')
<a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
<div class="container-fluid">
    <div class="row justify-content-center">
        <!-- Post Content Column -->
        <div class="col-lg-8">

            <!-- Title -->
            <h1 class="mt-4">{{$thread->title}}</h1>

            <!-- Author -->


            @if( Auth::user()->id == $thread->user_id)
            <p class="lead">
                by
                <h2>{{$user->name}}</h2>

            </p>
            @else
            <p class="lead">
                by
                <a href="{{ route('profile.index', ['id' => $thread->user_id ])}}">{{$user->name}}</a>

            </p>
            @endif
            <h3>Tag: {{$tag->name}}</h3>
            <hr>
            <!-- Date/Time -->
            <p>Posted on {{$thread->created_at}}</p>

            <hr>
            @if (Auth::user()->role == "member")

            @else
            @if (Auth::user()->role == "manager")
            <a href="#" class="btn btn-info">Get Notification</a>
            @else
            <a href="#" class="btn btn-info">Get Notification</a>
            @endif
            @endif

            <!-- thread Image -->
            <img src="{{asset('storage/thread/'.$thread->title.'/'.$thread->thumbnail.'/')}}" alt="Image">

            <hr>

            <!-- thread Detail -->
            <p class="lead">{{$thread->detail}}</p>

            

        </div>

    </div>
    <!-- /.row -->




</div>
@endsection