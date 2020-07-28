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

            @if(Auth::guest())
            <p class="lead">
                by
                <a href="{{ route('profile.index', ['id' => $user->id,'name' =>$user->name ])}}">{{$user->name}}</a>

            </p>
            @else
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
            @endif

            <p>Views: {{$value->count_id}}</p>

            <h3>Tag: {{$tag->name}}</h3>

            <!-- Date/Time -->
            <p>Posted on {{$value->created_at}}</p>

            @if(Auth::guest())

            @else
            @if (Auth::user()->role == 'member')

            @else

            <div>
                @if(Auth::guest())
                <a href="{{redirect('/login')}}" class="btn btn-info"> Get Notification</a>
                @else

                @if ($follower->follower_id?? '' == Auth::user()->id)
                <a href="{{route('unfollow.thread',['userid'=>Auth::user()->id,'threadid'=>$value->id])}}" class="btn btn-danger"> Stop getting Notification</a>
                @else
                <a href="{{route('follow.thread',['userid'=>Auth::user()->id,'threadid'=>$value->id])}}" class="btn btn-success">Get Notification</a>
                @endif
                @endif

            </div>

            @endif
            @endif


            <!-- thread Image -->
            <p>
                @if($value->thumbnail == NULL)
                <img src="{{asset('storage/blank.png')}}" alt="Image">
                @else
                <img src="{{asset('storage/thread/'.$value->title.'/'.$value->thumbnail.'/')}}" alt="Image">
                @endif
            </p>
            <hr>

            <!-- thread Detail -->
            <p class="lead">{{$value->detail}}</p>

        </div>

    </div>
    <!-- /.row -->

    <div>

        <div>
            <div>
                @if(Auth::guest())
                <a href="{{route('login')}}" style="color: crimson;">
                    <button class="like"> <i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;<span>Like</span>&nbsp;&nbsp;{{$value->likes->count()}}</button>
                </a>

                <i class="fa fa-commenting-o" aria-hidden="true"></i><span>Comment
                    {{$value->comments('id')->count()}}</span>

                <a href="{{route('thread.report.create',['threadid' => $value->id])}}" style="color: blue;">
                    <button> <i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;<span>Report</span></button>
                </a>
                @else

                @if($value->like->user_id?? '' == Auth::user()->id)
                @if(Auth::user()->role == 'manager')
                <a href="{{route('manager.unlike.post.thread',['threadid' => $value->id])}}" style="color: crimson;">
                    <button class="like"> <i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;<span>UnLike</span>&nbsp;&nbsp;{{$value->likes->count()}}</button>
                </a>
                @elseif(Auth::user()->role == 'admin')
                <a href="{{route('admin.unlike.post.thread',['threadid' => $value->id])}}" style="color: crimson;">
                    <button class="like"> <i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;<span>UnLike</span>&nbsp;&nbsp;{{$value->likes->count()}}</button>
                </a>
                @else
                <button class="like"> <i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;<span>Like</span>&nbsp;&nbsp;{{$value->likes->count()}}</button>
                @endif


                @else
                @if(Auth::user()->role == 'manager')
                <a href="{{route('manager.like.post.thread',['threadid' => $value->id])}}" style="color: green;">
                    @elseif(Auth::user()->role == 'admin')
                    <a href="{{route('admin.like.post.thread',['threadid' => $value->id])}}" style="color: green;">
                        @else
                        <a href="{{route('member.like.post.thread',['threadid' => $value->id])}}" style="color: green;">
                            @endif
                            <button class="like"> <i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;<span>Like</span>&nbsp;&nbsp;{{$value->likes->count()}}</button>
                        </a>
                        @endif
                        <i class="fa fa-commenting-o" aria-hidden="true"></i><span>Comment
                            {{$value->comments('id')->count()}}</span>
                        @if(Auth::user()->role == 'manager')
                        <a href="{{route('thread.report.create',['threadid' => $value->id])}}" style="color: blue;">
                            <button> <i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;<span>Report</span></button>
                        </a>
                        @else

                        @endif
                        @endif
            </div>
        </div>
        @if(Auth::guest())
        <div>
            <a href="{{route('login')}}">
                <p>
                    Đăng nhập để comment !!!!
                </p>
            </a>
        </div>
        @else
        <div>
            @if(Auth::user()->email_verified_at == NULL)
            
            @else
                @if(Auth::user()->role == 'manager')
                <form action="{{route('manager.comment.create.thread',['threadid' => $value->id])}}" method="POST" enctype="multipart/form-data">
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
                </form>
                @elseif (Auth::user()->role == 'admin')
                <form action="{{route('admin.comment.create.thread',['threadid' => $value->id])}}" method="POST" enctype="multipart/form-data">
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
                </form>
                @else
                <form action="{{route('member.comment.create.thread',['threadid' => $value->id])}}" method="POST" enctype="multipart/form-data">
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
                </form>
                @endif
            @endif
        </div>
        @endif

        <hr>
        <div>

            @foreach($value->comments as $comment)
            @if(Auth::guest())
            <div>
                {{$comment->comment_detail}}
            </div>
            <br>
            <div>
                @if($comment->comment_image == NULL)
                <img src="{{asset('storage/blank.png')}}" alt="Image" style="max-width: 200px ; max-height:200px;">
                @else
                <img src="{{asset('storage/comment/thread/'.$comment->comment_detail.'/'.$comment->comment_image)}}" alt="image" style="max-width: 200px ; max-height:200px;">
                @endif
            </div>

            @else
            @if( Auth::user()->role == 'admin')
            <div>
                {{$comment->comment_detail}}
            </div>
            <br>
            <div>
                @if($comment->comment_image == NULL)
                <img src="{{asset('storage/blank.png')}}" alt="Image" style="max-width: 200px ; max-height:200px;">
                @else
                <img src="{{asset('storage/comment/thread/'.$comment->comment_detail.'/'.$comment->comment_image)}}" alt="image" style="max-width: 200px ; max-height:200px;">
                @endif
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

            @elseif ( AUth::user()->role == 'manager')
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
            @else
            <div>
                {{$comment->comment_detail}}
            </div>
            <br>
            <div>
                @if($comment->comment_image == NULL)
                <img src="{{asset('storage/blank.png')}}" alt="Image" style="max-width: 200px ; max-height:200px;">
                @else
                <img src="{{asset('storage/comment/thread/'.$comment->comment_detail.'/'.$comment->comment_image)}}" alt="image" style="max-width: 200px ; max-height:200px;">
                @endif
            </div>
            @endif
            @endif

            @endforeach
        </div>

    </div>

    @endforeach
</div>
@endsection