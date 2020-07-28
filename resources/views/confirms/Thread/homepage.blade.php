@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    <div class="card border-primary">
        <h5 class="card-header bg-primary d-flex justify-content-between">
            <hr>

        </h5>
        <div class="text-right">
            @if(Auth::guest())

            @else
               
                   
                    @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.tag.add')}}">
                        <button type="button" class="btn btn-primary">Add Tag</button>
                    </a>
                    <a href="{{ route('admin.thread.add', ['id'=> $forum->id])}}">
                        <button type="button" class="btn btn-primary">Add Thread</button>
                    </a>
                    @else
                        @if(Auth::user()->email_verified_at == NULL)

                        @else
                            @if(Auth::user()->role == 'manager')
                            <a href="{{ route('manager.thread.add', ['id'=> $forum->id])}}">
                                <button type="button" class="btn btn-primary">Add Thread</button>
                            </a>
                            
                            @else
                            <a href="{{ route('member.thread.add', ['id'=> $forum->id])}}">
                                <button type="button" class="btn btn-primary">Add Thread</button>
                            </a>
                            @endif
                        @endif
                    @endif
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Banner</th>
                            <th>Title</th>
                            <th>Detail</th>
                            <th>Date</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($threads as $thread)
                        @if(Auth::guest())
                        <tr>
                            <td>{{$thread->id}}</td>
                            <td>
                                <a href="{{ route('thread.detail', ['id' => $forum->id ,'threadid' => $thread->id ])}}">
                                    <img src="{{asset('storage/thread/'.$thread->title.'/'.$thread->thumbnail.'/')}}" alt="Image" style="width:200px ;height:200px;">
                                </a>
                            </td>

                            <td>
                                <div>
                                    {{$thread->title}}
                                </div>
                            </td>
                            <td>{{$thread->detail}}</td>
                            <td>{{$thread->created_at}}</td>
                            <td>{{$thread->updated_at}}</td>
                            <td>Only for admin</td>
                        </tr>
                        @else
                        @if ($thread->status == "private")
                        @if( Auth::user()->role == "admin")
                        <tr>
                            <td>{{$thread->id}}</td>
                            <td>
                                <a href="{{ route('admin.thread.detail', ['id' => $forum->id ,'threadid' => $thread->id ])}}">
                                    <img src="{{asset('storage/thread/'.$thread->title.'/'.$thread->thumbnail.'/')}}" alt="Image" style="width:200px ;height:200px;">
                                </a>
                            </td>

                            <td>
                                <div>
                                    {{$thread->title}}
                                </div>
                            </td>
                            <td>{{$thread->detail}}</td>
                            <td>{{$thread->created_at}}</td>
                            <td>{{$thread->updated_at}}</td>
                            <td>
                                @if($thread->deleted_at != NULL)
                                <div class="pull-left">
                                    <a href="{{ route('admin.thread.restore', ['id' => $forum->id ,'threadid' =>$thread->id])}}">
                                        <button type="button" class="btn btn-success btn-lg">
                                            <i class="fa fa-undo"></i>
                                        </button>
                                    </a>
                                </div>
                                @else
                                <div class="pull-left">
                                    <a href="{{ route('admin.thread.edit', ['id' => $forum->id ,'threadid' =>$thread->id])}}">
                                        <button type="button" class="btn btn-info btn-lg">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </a>
                                </div>

                                <div class="pull-right">
                                    <a href="{{ route('admin.thread.delete', ['id' => $forum->id ,'threadid' =>$thread->id])}}">
                                        <button type="button" class="btn btn-danger btn-lg">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </a>
                                </div>
                                @endif

                            </td>
                        </tr>
                        @endif

                        @else
                        <tr>
                            @if (Auth::user()->role == 'admin')

                            <td>{{$thread->id}}</td>
                            <td>
                                <a href="{{ route('admin.thread.detail', ['id' => $forum->id ,'threadid' => $thread->id ])}}">
                                    @if($thread->thumbnail == NULL)
                                    <img src="{{asset('storage/blank.png')}}" alt="Image" style="width:200px ;height:200px;">
                                    @else
                                    <img src="{{asset('storage/thread/'.$thread->title.'/'.$thread->thumbnail.'/')}}" alt="Image" style="width:200px ;height:200px;">
                                    @endif
                                </a>
                            </td>

                            <td>
                                <div>
                                    {{$thread->title}}
                                </div>
                            </td>
                            <td>{{$thread->detail}}</td>
                            <td>{{$thread->created_at}}</td>
                            <td>{{$thread->updated_at}}</td>
                            <td>
                                @if($thread->deleted_at != NULL)
                                <div class="pull-left">
                                    <a href="{{ route('admin.thread.restore', ['id' => $forum->id ,'threadid' =>$thread->id])}}">
                                        <button type="button" class="btn btn-success btn-lg">
                                            <i class="fa fa-undo"></i>
                                        </button>
                                    </a>
                                </div>
                                @else
                                <div class="pull-left">
                                    <a href="{{ route('admin.thread.edit', ['id' => $forum->id ,'threadid' =>$thread->id])}}">
                                        <button type="button" class="btn btn-info btn-lg">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </a>
                                </div>

                                <div class="pull-right">
                                    <a href="{{ route('admin.thread.delete', ['id' => $forum->id ,'threadid' =>$thread->id])}}">
                                        <button type="button" class="btn btn-danger btn-lg">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </a>
                                </div>
                                @endif
                            </td>
                            @else
                                @if(Auth::user()->email_verified_at == NULL)

                                @else
                                    @if( Auth::user()->role == 'manager')
                                        @if($thread->deleted_at != NULL)

                                        @else
                                        <td>{{$thread->id}}</td>
                                        <td>
                                            <a href="{{ route('manager.thread.detail', ['id' => $forum->id ,'threadid' => $thread->id ])}}">
                                                <img src="{{asset('storage/thread/'.$thread->title.'/'.$thread->thumbnail.'/')}}" alt="Image" style="width:200px ;height:200px;">
                                            </a>
                                        </td>

                                        <td>
                                            <div>
                                                {{$thread->title}}
                                            </div>
                                        </td>
                                        <td>{{$thread->detail}}</td>
                                        <td>{{$thread->created_at}}</td>
                                        <td>{{$thread->updated_at}}</td>
                                        <td>

                                            @can('updatethread', $thread)
                                            <div class="pull-left">
                                                <a href="{{ route('manager.thread.edit', ['id' => $forum->id ,'threadid' =>$thread->id])}}">
                                                    <button type="button" class="btn btn-info btn-lg">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                            </div>
                                            @endcan

                                            @cannot('updatethread', $thread)

                                            @endcannot

                                            @can('deletethread', $thread)
                                            <div class="pull-right">
                                                <a href="{{ route('manager.thread.delete', ['id' => $forum->id ,'threadid' =>$thread->id])}}">
                                                    <button type="button" class="btn btn-danger btn-lg">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </a>
                                            </div>
                                            @endcan

                                            @cannot('deletethread', $thread)

                                            @endcannot
                                        </td>
                                        @endif
                                
                                    @else
                                    <td>{{$thread->id}}</td>
                                        <td>
                                            <a href="{{ route('member.thread.detail', ['id' => $forum->id ,'threadid' => $thread->id ])}}">
                                                @if($thread->thumbnail == NULL)
                                                <img src="{{asset('storage/blank.png')}}" alt="Image" style="width:200px ;height:200px;">
                                                @else
                                                <img src="{{asset('storage/thread/'.$thread->title.'/'.$thread->thumbnail.'/')}}" alt="Image" style="width:200px ;height:200px;">
                                                @endif
                                            </a>
                                        </td>

                                        <td>
                                            <div>
                                                {{$thread->title}}
                                            </div>
                                        </td>
                                        <td>{{$thread->detail}}</td>
                                        <td>{{$thread->created_at}}</td>
                                        <td>{{$thread->updated_at}}</td>
                                        <td> Only for Admin or Manager! </td>
                                    @endif
                                @endif  
                            @endif  
                        </tr>

                        @endif
                        @endif

                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        {{ $threads->links() }}

    </div>
</div>
@endsection