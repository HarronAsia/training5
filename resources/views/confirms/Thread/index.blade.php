@extends('layouts.app')

@section('content')
<a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
<div class="container-fluid">
    @foreach($thread as $value)
    <div class="row justify-content-center">

        <!-- Post Content Column -->
        <div class="col-lg-8">

            <!-- Title -->
            <h1 class="mt-4">{{$value->title}}</h1>

            <!-- Author -->


            @if( Auth::user()->id == $value->user_id)
            <p class="lead">
                by
                <h2>{{$user->name}}</h2>

            </p>
            @else
            <p class="lead">
                by
                <a href="{{ route('profile.index', ['id' => $user->id,'name' =>$user->name ])}}">{{$user->name}}</a>

            </p>
            @endif
            <h3>Tag: {{$tag->name}}</h3>
            <hr>
            <!-- Date/Time -->
            <p>Posted on {{$value->created_at}}</p>

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
            <img src="{{asset('storage/thread/'.$value->title.'/'.$value->thumbnail.'/')}}" alt="Image">

            <hr>

            <!-- thread Detail -->
            <p class="lead">{{$value->detail}}</p>

        </div>

    </div>
    <!-- /.row -->

    <div>

        <div>

            <a href="{{route('admin.like.post.thread',['threadid' => $value->id])}}" style="color: crimson;">
                <button class="like"> <i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;<span>Like</span>&nbsp;&nbsp;{{$value->likes->count()}}</button>
            </a>

            <i class="fa fa-commenting-o" aria-hidden="true"></i><span>Comment</span>

            <a href="" style="color: blue;">
                <button> <i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;<span>Report</span></button>
            </a>

        </div>
        <div>
            @if(Auth::user()->role == "manager")
            <form action="{{route('manager.comment.create.thread',['threadid' => $value->id])}}" method="POST" enctype="multipart/form-data">
                @else
                <form action="{{route('admin.comment.create.thread',['threadid' => $value->id])}}" method="POST" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="form-group">
                        <input type="text" name='comment_detail' placeholder="Your Comment">
                    </div>
                    <div class="form-group">

                        <img id="image_preview_container2" src="{{asset('storage/blank.png')}}" alt="preview Banner" style="max-width: 200px ; max-height:200px;">
                        <div>
                            <label for="comment_image">Upload Your image</label>
                            <input type="file" class="form-control" name="comment_image" id="comment_image">
                        </div>
                    </div>
                    <input type="submit" class="form-control form-control-lg" class="btn btn-success btn-block btn-lg">
                    @if(Auth::user()->role == "manager")
                </form>
                @else
            </form>
            @endif

        </div>

        <hr>
        <div>

            @foreach($value->comments as $comment)
            @if( Auth::user()->role == 'admin')
            <div>
                {{$comment->comment_detail}}
            </div>
            <br>
            <div>
                <img src="{{asset('storage/comment/thread/'.$comment->comment_detail.'/'.$comment->comment_image)}}" alt="image" style="max-width: 200px ; max-height:200px;">
            </div>
                @if($comment->deleted_at != NULL)
                <div class="pull-right">
                    <a href="{{route('admin.comment.restore.thread',['threadid' => $value->id,'commentid'=>$comment->id])}}">
                        <button type="button" class="btn btn-success btn-lg">
                            <i class="fa fa-undo"></i>
                        </button>
                    </a>
                </div>
                @else
                <div class="pull-right">
                    <a href="{{route('admin.comment.edit.thread',['threadid' => $value->id,'commentid'=>$comment->id])}}">
                        <button type="button" class="btn btn-info btn-lg">
                            <i class="fa fa-edit"></i>
                        </button>
                    </a>
                    <a href="{{route('admin.comment.delete.thread',['threadid' => $value->id,'commentid'=>$comment->id])}}">
                        <button type="button" class="btn btn-danger btn-lg">
                            <i class="fa fa-trash"></i>
                        </button>
                    </a>
                </div>
                @endif

            @else
                @if($comment->deleted_at != NULL)

                @else
                <div>
                    {{$comment->comment_detail}}
                </div>
                <br>
                <div>
                    <img src="{{asset('storage/comment/thread/'.$comment->comment_detail.'/'.$comment->comment_image)}}" alt="image" style="max-width: 200px ; max-height:200px;">
                </div>
                    @if(Auth::user()->id == $comment->user_id)
                        @if($comment->deleted_at != NULL)

                        @else
                        <div class="pull-right">
                            <a href="{{route('manager.comment.edit.thread',['threadid' => $value->id,'commentid'=>$comment->id])}}">
                                <button type="button" class="btn btn-info btn-lg">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </a>
                            <a href="{{route('manager.comment.delete.thread',['threadid' => $value->id,'commentid'=>$comment->id])}}">
                                <button type="button" class="btn btn-danger btn-lg">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </a>
                        </div>
                        @endif
                    @else

                    @endif

                @endif

            @endif

            @endforeach
        </div>

    </div>

    @endforeach
</div>
@endsection