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
            Threads by Admin list
        </h3>


        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Detail</th>
                            <th>Status</th>
                            <th>View</th>
                            <th>Created At </th>
                            <th>Last Updated</th>
                            <th>Deleted At</th>
                            <th>Thumbnail</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($threads as $thread)
                        <td>{{$thread->id}}</td>
                        <td>{{$thread->title}}</td>
                        <td>{{$thread->detail}}</td>
                        <td>{{$thread->status}}</td>
                        <td>{{$thread->count_id}}</td>
                        <td>{{$thread->created_at}}</td>
                        <td>{{$thread->updated_at}}</td>
                        <td>{{$thread->deleted_at}}</td>
                        <td>
                            @if ($thread->thumbnail == NULL)
                            <img src="{{asset('storage/blank.png')}}" alt="Image" style="width:200px ;height:200px;">
                            @else
                            <img src="{{asset('storage/thread/'.$thread->title.'/'.$thread->thumbnail.'/')}}" alt="Image" style="width:200px ;height:200px;">
                            @endif
                        </td>
                        <td>
                            @if($thread->deleted_at != NULL)
                           
                            <div class="pull-right">
                                <a href="{{ route('admin.thread.restore', ['id' => $thread->forum_id ,'threadid' =>$thread->id])}}">
                                    <button type="button" class="btn btn-success btn-lg">
                                        <i class="fa fa-undo"></i>
                                    </button>
                                </a>
                            </div>
                            @else
                            <div class="pull-right">
                                <a href="{{ route('admin.thread.edit', ['id' => $thread->forum_id ,'threadid' =>$thread->id])}}">
                                    <button type="button" class="btn btn-info btn-lg">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </a>
                            </div>

                            <div class="pull-right">
                                <a href="{{ route('admin.thread.delete', ['id' => $thread->forum_id ,'threadid' =>$thread->id])}}">
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
        {{$threads->links()}}
    </div>

</div>

@endsection