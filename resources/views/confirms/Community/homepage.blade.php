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
                <a href="{{ route('admin.community.add')}}">
                    <button type="button" class="btn btn-primary">Add Community</button>
                </a>
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
                            <th>Banner</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($communities as $community)
                        @if(Auth::guest())
                        <tr>
                            <td>{{$community->id}}</td>
                            <td>
                                <a href="{{ route('community.show',['id' => $community->id])}}">
                                    @if($community->banner != NULL)
                                    <img src="{{asset('storage/community/'.$community->title.'/'.$community->banner.'/')}}" alt="Image" style="width:200px ;height:200px;">
                                    @else
                                    <img src="{{asset('storage/blank.png')}}" alt="Image" style="width:200px ;height:200px;">
                                    @endif
                                </a>
                            </td>

                            <td>
                                <div>
                                    {{$community->title}}
                                </div>
                            </td>
                            <td>{{$community->created_at}}</td>
                            <td>{{$community->updated_at}}</td>
                            <td></td>
                        @else
                            @if( Auth::user()->role == "admin")
                            <tr>
                                <td>{{$community->id}}</td>
                                <td>
                                    <a href="{{ route('admin.community.show',['id' => $community->id])}}">
                                        @if($community->banner != NULL)
                                        <img src="{{asset('storage/community/'.$community->title.'/'.$community->banner.'/')}}" alt="Image" style="width:200px ;height:200px;">
                                        @else
                                        <img src="{{asset('storage/blank.png')}}" alt="Image" style="width:200px ;height:200px;">
                                        @endif
                                    </a>
                                </td>

                                <td>
                                    <div>
                                        {{$community->title}}
                                    </div>
                                </td>
                                <td>{{$community->created_at}}</td>
                                <td>{{$community->updated_at}}</td>
                                <td>
                                    @if($community->deleted_at != NULL)
                                    <div class="pull-left">
                                        <a href="{{route('admin.community.restore',['id' => $community->id])}}">
                                            <button type="button" class="btn btn-success btn-lg">
                                                <i class="fa fa-undo"></i>
                                            </button>
                                        </a>
                                    </div>
                                    @else
                                    <div class="pull-left">
                                        <a href="{{route('admin.community.edit',['id' => $community->id])}}">
                                            <button type="button" class="btn btn-info btn-lg">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </a>
                                    </div>

                                    <div class="pull-right">
                                        <a href="{{route('admin.community.delete',['id' => $community->id])}}">
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
                                <td>{{$community->id}}</td>
                                <td>
                                    <a href="{{ route('manager.community.show',['id' => $community->id])}}">
                                        @if($community->banner != NULL)
                                        <img src="{{asset('storage/community/'.$community->title.'/'.$community->banner.'/')}}" alt="Image" style="width:200px ;height:200px;">
                                        @else
                                        <img src="{{asset('storage/blank.png')}}" alt="Image" style="width:200px ;height:200px;">
                                        @endif
                                    </a>
                                </td>

                                <td>
                                    <div>
                                        {{$community->title}}
                                    </div>
                                </td>
                                <td>{{$community->created_at}}</td>
                                <td>{{$community->updated_at}}</td>
                                <td>For Admin Only</td>
                            </tr>
                            @endif
                        @endif
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        {{ $communities->links() }}

    </div>
</div>
@endsection