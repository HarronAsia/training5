@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="card-header" align="center">
            <a href="{{ route('admin.export.users')}}" class="btn btn-success">
                <i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export Users
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Date Of Birth</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Last Updated</th>
                            <th>Email Verified At</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>
                                @if ($user->photo == NULL)
                                <img src="{{asset('storage/default.png')}}" alt="Image" style="width:200px ;height:200px;">
                                @else
                                <img src="{{asset('storage/'.$user->name.'/'.$user->photo)}}" alt="Image" style="width:200px ;height:200px;">
                                @endif
                            </td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->password}}</td>
                            <td>{{$user->dob}}</td>
                            <td>{{$user->number}}</td>
                            <td>{{$user->role}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->updated_at}}</td>
                            <td>{{$user->email_verified_at}}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        {{$users->links()}}
    </div>
</div>

@endsection