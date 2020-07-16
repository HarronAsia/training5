@extends('layouts.app')

@section('content')
<div class="container-fluid ">
    <div class="row justify-content-center">


        <div class="col-lg-12">

            <h4 class="text-center text-primary mt-2"> Harron the Intern </h4>
        </div>
    </div>

    <div class="card border-primary">
        <a href="javascript:history.back()" class="btn btn-primary">Back</a>
        <hr>
        <h3 class="card-header bg-primary d-flex justify-content-between">
           Admins list
        </h3>


        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>DOB</th>
                            <th>Phone Number</th>
                            <th>Avatar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <td>{{$user->id}}</td>

                        <td>
                            <div>
                                {{$user->name}}
                            </div>
                        </td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->password}}</td>
                        <td>{{$user->dob}}</td>
                        <td>{{$user->number}}</td>
                        <td>
                            @if ($user->photo == NULL)
                            <img src="{{asset('storage/default.png')}}" alt="Image" style="width:200px ;height:200px;">
                            @else
                            <img src="{{asset('storage/'.$user->name.'/'.$user->photo)}}" alt="Image" style="width:200px ;height:200px;">
                            @endif
                        </td>
                        <td>
                            @if ( Auth::user()->id == $user->id)

                            @else
                            <div class="pull-left">
                                <a href="/admin/admin/{{$user->id}}/edit">
                                    <button type="button" class="btn btn-info btn-lg">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </a>
                            </div>

                            <div class="pull-left">
                                <a href="/admin/admin/{{$user->id}}/delete">
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

    </div>

</div>

@endsection