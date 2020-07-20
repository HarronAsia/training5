@extends('layouts.app')

@section('content')
<a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
<div class="container-fluid">
    <div class="row justify-content-center">

        <!-- Post Content Column -->
        <div class="col-md-8">

            <!-- Title -->
            <h1 class="mt-4">{{$community->title}}</h1>


            <!-- Date/Time -->
            <p>Created on {{$community->created_at}}</p>


            @if (Auth::user()->role == "member")

            @else
            @if (Auth::user()->role == "manager")
            <a href="#" class="btn btn-info">Follow {{$community->title}}</a>
            @else
            <a href="#" class="btn btn-info">Follow {{$community->title}}</a>
            @endif
            @endif

            <!-- thread Image -->
            <img src="{{asset('storage/community/'.$community->title.'/'.$community->banner.'/')}}" alt="Image">

        </div>

    </div>
    <br>
    <div class="row justify-content-center bg-danger">
        <div>
            <h1>Share your experiences</h1>
        </div>
        @if (Auth::user()->role == "member")

        @else
        @if(Auth::user()->role == "manager")
        <form action="{{ route('manager.post.create',['id'=>$community->id])}}" method="POST" enctype="multipart/form-data">
            @else
            <form action="{{ route('admin.post.create',['id'=>$community->id])}}" method="POST" enctype="multipart/form-data">
                @endif
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

    </div>
    <br>
    <!-- /.row -->

    <div class="row justify-content-center bg-info">

        @foreach($posts as $post)
        <h5>This is post {{$post->id}}</h5>
        <div>

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
            @else
            @if(Auth::user()->id != $user->id)

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
            @endif



            <div>
                {{$post->detail??''}}
            </div>

            <div>
                <img src="{{asset('storage/post/'.$post->user_id.'/'.$post->image.'/')}}" alt="Image" style="max-width: 600px ; max-height:600px;">
            </div>

            <div>

                <div>
                    <h4>Comments</h4>
                    <?php $likes = App\Like::get()->where('likeable_id', $post->id)->count(); ?>



                    <a href="{{route('admin.like.post',['postid' => $post->id])}}" style="color: crimson;">
                        <button class="like"> <i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;<span>Like</span>&nbsp;&nbsp;{{$likes}}</button>
                    </a>

                    <i class="fa fa-commenting-o" aria-hidden="true"></i><span>Comment</span>

                    <a href="" style="color: blue;">
                        <button class="like"> <i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;<span>Report</span></button>
                    </a>

                </div>
                <div>
                    @if(Auth::user()->role == "manager")
                    <form action="{{route('manager.comment.create',['postid' => $post->id])}}" method="POST" enctype="multipart/form-data">
                        @else
                        <form action="{{route('admin.comment.create',['postid' => $post->id])}}" method="POST" enctype="multipart/form-data">
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
                </div>

            </div>
            <div>
                <?php $comments = App\Comment::get()->where('commentable_id', '=', $post->id); ?>
                @foreach($comments as $comment)

                @if(Auth::user()->role == 'admin')
                <div>
                    {{$comment->comment_detail}}
                </div>
                <br>
                <div>
                    <img src="{{asset('storage/comment/'.$comment->user_id.'/'.$comment->comment_image)}}" alt="image" style="max-width: 200px ; max-height:200px;">
                </div>
                @if($post->deleted_at != NULL)
                <div class="pull-right">
                    <a href="{{route('admin.comment.edit',['postid' => $post->id,'commentid'=>$comment->id])}}">
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
                @else
                <?php $comments = App\Comment::get()->where('commentable_id', '=', $post->id)->where('deleted_at', NULL); ?>
                @if($post->deleted_at != NULL)

                @else
                <div>
                    {{$comment->comment_detail}}
                </div>
                <br>
                <div>
                    <img src="{{asset('storage/comment/'.$comment->user_id.'/'.$comment->comment_image)}}" alt="image" style="max-width: 200px ; max-height:200px;">
                </div>
                @endif
                @if(Auth::user()->id != $user->id)

                @else
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
                @endif
                @endif
                @endforeach
            </div>
            <hr>
        </div>

        @endforeach

    </div>
    {{$posts->links()}}
</div>
@endsection