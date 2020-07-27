@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

        <div class="container">
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h4 class="modal-title text-light">Edit Category</h4>
                    </div>

                    <div class="modal-body">

                        <form action="{{ route('admin.category.edit.confirm', ['id'=> $category->id])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="name" class="form-control form-control-lg" placeholder="Enter Name" value="{{$category->name}}"required>
                            </div>

                            <div class="form-group">
                                <input type="text" name="detail" class="form-control form-control-lg" placeholder="Enter Detail" value="{{$category->detail}}" required>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="form-control form-control-lg" class="btn btn-success btn-block btn-lg">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection