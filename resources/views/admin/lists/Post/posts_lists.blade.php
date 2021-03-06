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
            All Posts
        </h3>


        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Detail</th>
                            <th>From User ID</th>
                            <th>From Community ID</th>
                            <th>Created At </th>
                            <th>Last Updated</th>
                            <th>Deleted At</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                        <td>{{$post->id}}</td>
                        <td>{{$post->detail}}</td>
                        <td>{{$post->user_id}}</td>
                        <td>{{$post->community_id}}</td>
                        <td>{{$post->created_at}}</td>
                        <td>{{$post->updated_at}}</td>
                        <td>{{$post->deleted_at}}</td>
                        <td>
                            @if($post->image == NULL)
                            <img src="{{asset('storage/blank.png')}}" alt="Image">
                            @else
                            <img src="{{asset('storage/post/'.$post->user_id.'/'.$post->image.'/')}}" alt="Image" style="max-width: 600px ; max-height:600px;">
                            @endif
                        </td>
                        <td>
                            @if($post->deleted_at != NULL)
                            <div class="pull-right">
                                <a href="{{ route('posts.admin.restore', ['postid'=> $post->id])}}">
                                    <button type="button" class="btn btn-success btn-lg">
                                        <i class="fa fa-undo"></i>
                                    </button>
                                </a>
                            </div>
                            @else
                            <div class="pull-right">
                                <a href="{{ route('posts.admin.edit', ['postid'=> $post->id])}}">
                                    <button type="button" class="btn btn-info btn-lg">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('posts.admin.delete', ['postid'=> $post->id])}}">
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
        {{$posts->links()}}
    </div>

</div>

@endsection