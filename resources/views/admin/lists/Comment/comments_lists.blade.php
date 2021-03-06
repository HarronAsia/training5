@extends('layouts.app')

@section('content')

<div class="container-fluid ">
    <div class="row justify-content-center">


        <div class="col-lg-12">

            <h4 class="text-center text-primary mt-2"> Harron the Intern </h4>
        </div>
    </div>

    <div class="card border-primary">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        <hr>
        <h3 class="card-header bg-primary d-flex justify-content-between">
            All Comments;
        </h3>


        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Detail</th>
                            <th>Where</th>
                            <th>Created At </th>
                            <th>Last Updated</th>
                            <th>Deleted At</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $comment)
                        <td>{{$comment->id}}</td>
                        <td>{{$comment->comment_detail}}</td>
                        <td>{{$comment->commentable_type}}</td>
                        <td>{{$comment->created_at}}</td>
                        <td>{{$comment->updated_at}}</td>
                        <td>{{$comment->deleted_at}}</td>
                        <td>
                            @if($comment->comment_image == NULL)
                            <img src="{{asset('storage/blank.png')}}" alt="Image" style="max-width: 200px ; max-height:200px;">
                            @else
                                @if($comment->commentable_type == 'App\Post')
                                <img src="{{asset('storage/comment/post/'.$comment->comment_detail.'/'.$comment->comment_image)}}" alt="image" style="max-width: 200px ; max-height:200px;">
                                @else
                                <img src="{{asset('storage/comment/thread/'.$comment->comment_detail.'/'.$comment->comment_image)}}" alt="image" style="max-width: 200px ; max-height:200px;">
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($comment->deleted_at != NULL)
                            <div class="pull-right">
                                <a href="{{route('comments.admin.restore',['commentid'=>$comment->id])}}">
                                    <button type="button" class="btn btn-success btn-lg">
                                        <i class="fa fa-undo"></i>
                                    </button>
                                </a>
                            </div>
                            @else
                            <div class="pull-right">
                                <a href="{{route('comments.admin.edit',['commentid'=>$comment->id])}}">
                                    <button type="button" class="btn btn-info btn-lg">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </a>
                                <a href="{{route('comments.admin.delete',['commentid'=>$comment->id])}}">
                                    <button type="button" class="btn btn-danger btn-lg">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </a>
                            </div>
                            @endif
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        {{$comments->links()}}
    </div>

</div>

@endsection