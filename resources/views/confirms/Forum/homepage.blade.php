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
                    @if(Auth::guest())

                    @else
                        @if(Auth::user()->role == 'admin')
                        <div class="text-right">
                            <a href="{{ route('admin.forum.add', ['categoryid'=> $category->id])}}">
                                <button type="button" class="btn btn-primary">Add Forum</button>
                            </a>
                        </div>
                        @elseif(Auth::user()->role == 'manager')
                        <div class="text-right">
                            <a href="{{ route('manager.forum.add', ['categoryid'=> $category->id])}}">
                                <button type="button" class="btn btn-primary">Add Forum</button>
                            </a>
                        </div>
                        @else

                        @endif


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
                                @if(Auth::guest())

                                @if($forum->deleted_at == NULL)

                                @else
                                <tr>
                                    <td>{{$forum->id}}</td>
                                    <td><a href="{{ route('thread.show', ['id'=>  $forum->id])}}">{{$forum->title}} </a></td>
                                </tr>
                                @endif

                                @else
                                    @if( Auth::user()->role == 'admin')
                                    <tr>

                                        <td>{{$forum->id}}</td>
                                        <td><a href="{{ route('admin.thread.show', ['id'=>  $forum->id])}}">{{$forum->title}} </a></td>
                                        <td>
                                            @if($forum->deleted_at != NULL)
                                            <div class="pull-right">
                                                <a href="{{ route('admin.forum.restore', ['categoryid'=> $category->id,'forumid' => $forum->id])}}">
                                                    <button type="button" class="btn btn-success btn-lg">
                                                        <i class="fa fa-undo"></i>
                                                    </button>
                                                </a>
                                            </div>
                                            @else
                                            <div class="pull-right">
                                                <a href="{{ route('admin.forum.edit', ['categoryid'=> $category->id,'forumid' => $forum->id])}}">
                                                    <button type="button" class="btn btn-info btn-lg">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                            </div>
                                            <div class="pull-right">
                                                <a href="{{ route('admin.forum.delete', ['categoryid'=> $category->id,'forumid' => $forum->id])}}">
                                                    <button type="button" class="btn btn-danger btn-lg">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </a>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                @elseif(Auth::user()->role == 'manager')
                                <tr>
                                    @if($forum->deleted_at != NULL)

                                    @else
                                    <td>{{$forum->id}}</td>
                                    <td>
                                        <a href="{{ route('manager.thread.show', ['id'=>  $forum->id])}}">{{$forum->title}} </a>
                                    </td>
                                    <td>
                                        @if(Auth::user()->email_verified_at)

                                        @else
                                            @if(Auth::user()->id == $forum->user_id)
                                            <div class="pull-right">
                                                <a href="{{ route('manager.forum.edit', ['categoryid'=> $category->id,'forumid' => $forum->id])}}">
                                                    <button type="button" class="btn btn-info btn-lg">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                            </div>

                                            <div class="pull-right">
                                                <a href="{{ route('manager.forum.delete', ['categoryid'=> $category->id,'forumid' => $forum->id])}}">
                                                    <button type="button" class="btn btn-danger btn-lg">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </a>
                                            </div>
                                            @else

                                            @endif
                                        @endif
                                        
                                    @endif
                                    </td>

                                </tr>
                                @else
                                <tr>
                                    @if($forum->deleted_at != NULL)

                                    @else
                                    <td>{{$forum->id}}</td>
                                    <td>
                                        <a href="{{ route('member.thread.show', ['id'=>  $forum->id])}}">{{$forum->title}} </a>
                                    </td>
                                    <td>
                                        Only for admin or Manager
                                    </td>
                                    @endif


                                </tr>
                                @endif

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