@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        <h1>WELCOME {{Auth::user()->name}}</h1>

        <h3>Let's review and confirm your Category before add to the website</h3>

        <h3 style="color: red;"><b>Don't worry the information here can only be seen by you !</b></h3>

        <h1 align="center">Confirmation page</h1>

        <div>
            <div class="form-group">
                <label for="name">Category name</label>
                <div>{{$category['name']}}</div>
            </div>

            <div class="form-group">
                <label for="detail">Category Detail</label>
                <div>{{$category['detail']}}</div>
            </div>

        </div>

        <!-- SUbmit Form -->

        <form action="{{ route('admin.category.create')}}" method="POST" enctype="multipart/form-data">

            @csrf
            <input type="hidden" name='name' value="{{$category->name}}">
            <input type="hidden" name='detail' value="{{$category->detail}}">

            <div class="form-group">
                <input type="submit" class="form-control form-control-lg" class="btn btn-success btn-block btn-lg">
            </div>
        </form>
        <!-- SUbmit Form -->
    </div>
</div>

@endsection