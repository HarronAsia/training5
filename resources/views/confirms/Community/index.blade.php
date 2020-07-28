@extends('layouts.app')

@section('content')
<a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
<div class="container-fluid">
    <div class="row justify-content-center">

        <!-- Post Content Column -->
        <div class="col-md-8">
            @if($community->banner != NULL)
            <img src="{{asset('storage/community/'.$community->title.'/'.$community->banner.'/')}}" alt="Image" style="width:100px ;height:100px;">
            @else
            <img src="{{asset('storage/blank.png')}}" alt="Image" style="width:100px ;height:100px;">
            @endif
            <!-- Title -->
            <h1 class="mt-4">{{$community->title}}</h1>


            <!-- Date/Time -->
            <p>Created on {{$community->created_at}}</p>

            @if(Auth::guest())

            @else
            @if (Auth::user()->role == 'member')
            <a href="{{redirect('/login')}}" class="btn btn-info"> Get Notification</a>
            @else

            <div>

                @if ($follower->follower_id?? '' == Auth::user()->id)
                <a href="{{route('unfollow.community',['userid'=>Auth::user()->id,'communityid'=>$community->id])}}" class="btn btn-danger"> Stop getting Notification</a>
                @else
                <a href="{{route('follow.community',['userid'=>Auth::user()->id,'communityid'=>$community->id])}}" class="btn btn-success">Get Notification</a>
                @endif

            </div>

            @endif
            @endif

        </div>

    </div>
    <br>
    <div class="row justify-content-center bg-danger">
        <div>
            <h1>Share your experiences</h1>
        </div>
        @if(Auth::guest())

        @else
            @if(Auth::user()->role == 'admin')
            <form action="{{ route('admin.post.create',['id'=>$community->id])}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="text" name="detail" class="form-control form-control-lg" placeholder="Enter Your thought" required>
                </div>

                <div class="form-group">

                    <img id="image_preview_container" src="{{asset('storage/blank.png')}}" alt="preview Banner" style="max-width: 500px ; max-height:500px;">
                    <div>
                        <label for="image">Upload Your image</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" class="form-control form-control-lg" class="btn btn-success btn-block btn-lg">
                </div>
            </form>
            @else
                @if(Auth::user()->email_verified_at == NULL)

                @else
                    @if(Auth::user()->role == 'manager')
                    <form action="{{ route('manager.post.create',['id'=>$community->id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="detail" class="form-control form-control-lg" placeholder="Enter Your thought" required>
                        </div>

                        <div class="form-group">

                            <img id="image_preview_container" src="{{asset('storage/blank.png')}}" alt="preview Banner" style="max-width: 500px ; max-height:500px;">
                            <div>
                                <label for="image">Upload Your image</label>
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="form-control form-control-lg" class="btn btn-success btn-block btn-lg">
                        </div>
                    </form>
                    @else
                        <form action="{{ route('member.post.create',['id'=>$community->id])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="detail" class="form-control form-control-lg" placeholder="Enter Your thought" required>
                            </div>

                            <div class="form-group">

                                <img id="image_preview_container" src="{{asset('storage/blank.png')}}" alt="preview Banner" style="max-width: 500px ; max-height:500px;">
                                <div>
                                    <label for="image">Upload Your image</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="form-control form-control-lg" class="btn btn-success btn-block btn-lg">
                            </div>
                        </form>
                    @endif
                @endif
            @endif
        @endif
        
    </div>
    <br>
    <!-- /.row -->

    <div class="row justify-content-center bg-info">

        @foreach($posts as $post)
        <h5>This is post {{$post->id}}</h5>
        <div>
            @if(Auth::guest())

            @else
            @if(Auth::user()->role == 'admin')
                @if($post->deleted_at != NULL)
                <div class="pull-right">
                    <a href="{{route('admin.post.restore',['id' => $community->id,'postid'=>$post->id])}}">
                        <button type="button" class="btn btn-success btn-lg">
                            <i class="fa fa-undo"></i>
                        </button>
                    </a>
                </div>
                @else
                <div class="pull-right">
                    <a href="{{route('admin.post.edit',['id' => $community->id,'postid'=>$post->id])}}">
                        <button type="button" class="btn btn-info btn-lg">
                            <i class="fa fa-edit"></i>
                        </button>
                    </a>
                    <a href="{{route('admin.post.delete',['id' => $community->id,'postid'=>$post->id])}}">
                        <button type="button" class="btn btn-danger btn-lg">
                            <i class="fa fa-trash"></i>
                        </button>
                    </a>
                </div>
                @endif
            @elseif(Auth::user()->role == 'manager')
                @if(Auth::user()->id != $post->user_id)

                @else
                <div class="pull-right">
                    <a href="{{route('manager.post.edit',['id' => $community->id,'postid'=>$post->id])}}">
                        <button type="button" class="btn btn-info btn-lg">
                            <i class="fa fa-edit"></i>
                        </button>
                    </a>
                    <a href="{{route('manager.post.delete',['id' => $community->id,'postid'=>$post->id])}}">
                        <button type="button" class="btn btn-danger btn-lg">
                            <i class="fa fa-trash"></i>
                        </button>
                    </a>
                </div>
                @endif
            @else

            @endif
            @endif

            <div>
                {{$post->detail??''}}
            </div>

            <div>
                @if($post->image == NULL)
                <img src="{{asset('storage/blank.png')}}" alt="Image">
                @else
                <img src="{{asset('storage/post/'.$post->user_id.'/'.$post->image.'/')}}" alt="Image" style="max-width: 600px ; max-height:600px;">
                @endif
            </div>

            <div>

                <div>
                    @if(Auth::guest())
                    <a href="{{route('login')}}" style="color: crimson;">
                        <button class="like"> <i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;<span>Like</span>&nbsp;&nbsp;{{$post->likes->count()}}</button>
                    </a>

                    <i class="fa fa-commenting-o" aria-hidden="true"></i><span>Comment {{$post->comments('id')->count()}}</span>
                    @else

                    @if($post->like->user_id?? '' == Auth::user()->id)
                    @if(Auth::user()->role == 'manager')
                    <a href="{{route('manager.unlike.post',['postid' => $post->id])}}" style="color: crimson;">
                        @else
                        <a href="{{route('admin.unlike.post',['postid' => $post->id])}}" style="color: crimson;">
                            @endif
                            <button class="like"> <i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;<span>UnLike</span>&nbsp;&nbsp;{{$post->likes->count()}}</button>
                        </a>

                        @else
                        @if(Auth::user()->role == 'manager')
                        <a href="{{route('manager.like.post',['postid' => $post->id])}}" style="color: green;">
                            @elseif(Auth::user()->role =='admin')
                            <a href="{{route('admin.like.post',['postid' => $post->id])}}" style="color: green;">
                                @else
                                <a href="{{route('member.like.post',['postid' => $post->id])}}" style="color: green;">
                                @endif
                                <button class="like"> <i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;<span>Like</span>&nbsp;&nbsp;{{$post->likes->count()}}</button>
                            </a>
                            @endif
                            <i class="fa fa-commenting-o" aria-hidden="true"></i><span>Comment {{$post->comments('id')->count()}}</span>
                            @endif
                </div>
                @if(Auth::guest())

                @else
                <div>
                    @if(Auth::user()->role == 'admin')
                        <form action="{{route('admin.comment.create',['postid' => $post->id])}}" method="POST" enctype="multipart/form-data">
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
                                @if(Auth::user()->email_verified_at == NULL)

                                @else
                                @if(Auth::user()->role == 'manager')
                                <form action="{{route('manager.comment.create',['postid' => $post->id])}}" method="POST" enctype="multipart/form-data">            
                                    @else
                                    <form action="{{route('member.comment.create',['postid' => $post->id])}}" method="POST" enctype="multipart/form-data">
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
                                    </form>
                                @endif
                            @endif
                   
                            
                            
                            
                </div>
                @endif

            </div>

            <h3 style="background-color: blue;">
                All Comments
            </h3>
            <div>
                @foreach($post->comments as $comment)
                @if(Auth::guest())
                <div>
                    <p>{{$comment->comment_detail}}</p>

                </div>

                <div>
                    @if($comment->comment_image == NULL)
                    <img src="{{asset('storage/blank.png')}}" alt="Image" style="max-width: 200px ; max-height:200px;">
                    @else
                    <img src="{{asset('storage/comment/post/'.$comment->comment_detail.'/'.$comment->comment_image)}}" alt="image" style="max-width: 200px ; max-height:200px;">
                    @endif
                </div>

                @else
                @if(Auth::user()->role == 'admin')
                <div>
                    <p>{{$comment->comment_detail}}</p>

                </div>

                <div>
                    @if($comment->comment_image == NULL)
                    <img src="{{asset('storage/blank.png')}}" alt="Image" style="max-width: 200px ; max-height:200px;">
                    @else
                    <img src="{{asset('storage/comment/post/'.$comment->comment_detail.'/'.$comment->comment_image)}}" alt="image" style="max-width: 200px ; max-height:200px;">
                    @endif

                    @if($comment->deleted_at != NULL)
                    <div class="pull-right">
                        <a href="{{route('admin.comment.restore',['postid' => $post->id,'commentid'=>$comment->id])}}">
                            <button type="button" class="btn btn-success btn-lg">
                                <i class="fa fa-undo"></i>
                            </button>
                        </a>
                    </div>
                    @else
                    <div class="pull-right">
                        <a href="{{route('admin.comment.edit',['postid' => $post->id,'commentid'=>$comment->id])}}">
                            <button type="button" class="btn btn-info btn-lg">
                                <i class="fa fa-edit"></i>
                            </button>
                        </a>
                        <a href="{{route('admin.comment.delete',['postid' => $post->id,'commentid'=>$comment->id])}}">
                            <button type="button" class="btn btn-danger btn-lg">
                                <i class="fa fa-trash"></i>
                            </button>
                        </a>
                    </div>
                    @endif
                </div>

                @elseif(Auth::user() == 'manager')
                    @if($comment->deleted_at != NULL)

                    @else
                    <div>
                        {{$comment->comment_detail}}
                    </div>

                    <div>
                        @if($comment->comment_image == NULL)
                        <img src="{{asset('storage/blank.png')}}" alt="Image" style="max-width: 200px ; max-height:200px;">
                        @else
                        <img src="{{asset('storage/comment/post/'.$comment->comment_detail.'/'.$comment->comment_image)}}" alt="image" style="max-width: 200px ; max-height:200px;">
                        @endif

                        @if(Auth::user()->id == $comment->user_id)
                        <div class="pull-right">
                            <a href="{{route('manager.comment.edit',['postid' => $post->id,'commentid'=>$comment->id])}}">
                                <button type="button" class="btn btn-info btn-lg">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </a>
                            <a href="{{route('manager.comment.delete',['postid' => $post->id,'commentid'=>$comment->id])}}">
                                <button type="button" class="btn btn-danger btn-lg">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </a>
                        </div>
                        @else

                        @endif
                    </div>
                    @endif
                @else
                <div>
                        {{$comment->comment_detail}}
                    </div>

                    <div>
                        @if($comment->comment_image == NULL)
                        <img src="{{asset('storage/blank.png')}}" alt="Image" style="max-width: 200px ; max-height:200px;">
                        @else
                        <img src="{{asset('storage/comment/post/'.$comment->comment_detail.'/'.$comment->comment_image)}}" alt="image" style="max-width: 200px ; max-height:200px;">
                        @endif
                    </div>
                @endif
                @endif

                @endforeach
            </div>

        </div>
        <h3 style="background-color: wheat;">
            &nbsp;
        </h3>
        @endforeach

    </div>
    {{$posts->links()}}
</div>
@endsection