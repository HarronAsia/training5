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
            All Communities
        </h3>


        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Created At </th>
                            <th>Last Updated</th>
                            <th>Deleted At</th>
                            <th>Banner</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($communities as $community)
                        <td>{{$community->id}}</td>
                        <td>{{$community->title}}</td>
                        <td>{{$community->created_at}}</td>
                        <td>{{$community->updated_at}}</td>
                        <td>{{$community->deleted_at}}</td>
                        <td>
                            @if($community->banner != NULL)
                            <img src="{{asset('storage/community/'.$community->title.'/'.$community->banner.'/')}}" alt="Image" style="width:200px ;height:200px;">
                            @else
                            <img src="{{asset('storage/blank.png')}}" alt="Image" style="width:200px ;height:200px;">
                            @endif
                        </td>
                        <td>
                            @if($community->deleted_at != NULL)
                            <div class="pull-right">
                                <a href="{{ route('communities.admin.restore', ['communityid'=> $community->id])}}">
                                    <button type="button" class="btn btn-success btn-lg">
                                        <i class="fa fa-undo"></i>
                                    </button>
                                </a>
                            </div>
                            @else
                            <div class="pull-right">
                                <a href="{{ route('communities.admin.edit', ['communityid'=> $community->id])}}">
                                    <button type="button" class="btn btn-info btn-lg">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('communities.admin.delete', ['communityid'=> $community->id])}}">
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
        {{$communities->links()}}
    </div>

</div>

@endsection