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
            All Categories
        </h3>


        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Detail</th>
                            <th>Created At </th>
                            <th>Last Updated</th>
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->detail}}</td>
                        <td>{{$category->created_at}}</td>
                        <td>{{$category->updated_at}}</td>
                        <td>{{$category->deleted_at}}</td>
                        <td>
                            @if($category->deleted_at != NULL)
                            <div class="pull-right">
                                <a href="{{ route('categories.admin.restore', ['categoryid'=> $category->id])}}">
                                    <button type="button" class="btn btn-success btn-lg">
                                        <i class="fa fa-undo"></i>
                                    </button>
                                </a>
                            </div>
                            @else
                            <div class="pull-right">
                                <a href="{{ route('categories.admin.edit', ['categoryid'=> $category->id])}}">
                                    <button type="button" class="btn btn-info btn-lg">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('categories.admin.delete', ['categoryid'=> $category->id])}}">
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
        {{$categories->links()}}
    </div>

</div>

@endsection