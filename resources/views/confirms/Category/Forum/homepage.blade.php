@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    <div class="row justify-content-center">

        <h1>Harron.vm</h1>

        <ol class="list-group">
            <li class="list-group-item">
                <div>
                    <div class="bg-danger text-dark" style="font-size: 25px;">

                        {{$category->name}}
                        <div class="bg-danger text-dark" style="font-size: 15px;">
                            {{$category->detail}}

                        </div>

                    </div>
                    @if(Auth::user()->role == 'manager')
                    <div class="text-right">
                        <a href="{{ route('manager.forum.add', ['id'=> $category->id])}}">
                            <button type="button" class="btn btn-primary">Add Forum</button>
                        </a>
                    </div>
                    @else
                    <div class="text-right">
                        <a href="{{ route('admin.forum.add', ['id'=> $category->id])}}">
                            <button type="button" class="btn btn-primary">Add Forum</button>
                        </a>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="showBlog">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Title</th>
                                    <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach($forums as $forum)
                                @if( Auth::user()->role == "admin")
                                <tr>

                                    <td>{{$forum->id}}</td>
                                    <td><a href="{{ route('thread.show', ['id'=> $forum->id])}}">{{$forum->title}} </a></td>
                                    <td>
                                        @if($forum->deleted_at != NULL)
                                        <div class="pull-left">
                                            <a href="{{ route('admin.forum.restore', ['id'=> $forum->id])}}">
                                                <button type="button" class="btn btn-success btn-lg">
                                                    <i class="fa fa-undo"></i>
                                                </button>
                                            </a>
                                        </div>
                                        @else
                                        <div class="pull-right">
                                            <a href="{{ route('admin.forum.edit', ['id'=> $forum->id])}}">
                                                <button type="button" class="btn btn-info btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{ route('admin.forum.delete', ['id'=> $forum->id])}}">
                                                <button type="button" class="btn btn-danger btn-lg">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </a>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @else
                                <tr>

                                    <td>{{$forum->id}}</td>
                                    <td>{{$forum->title}} </td>
                                    <td>
                                        @if($forum->deleted_at != NULL)

                                        @else

                                        <div class="pull-right">
                                            <a href="{{ route('manager.forum.edit', ['id'=> $forum->id])}}">
                                                <button type="button" class="btn btn-info btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{ route('manager.forum.delete', ['id'=> $forum->id])}}">
                                                <button type="button" class="btn btn-danger btn-lg">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </a>
                                        </div>
                                        @endif
                                    </td>
                                </tr>

                                @endif

                                @endforeach
                                
                            </tbody>
                        </table>
                        
                    </div>
                </div>
                
            </li>
        </ol>
        
    </div>

</div>
{{ $forums->links() }}
@endsection