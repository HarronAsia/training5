@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

        <div class="container">
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h4 class="modal-title text-light">Add Forum</h4>
                    </div>
                    @if(Auth::user()->role == "manager")
                    <div class="modal-body">

                        <form action="{{ route('manager.forum.create', ['categoryid'=> $category->id])}}" method="POST">

                            @csrf
                            <div class="form-group">
                                <input type="text" name="title" class="form-control form-control-lg" placeholder="Enter title" required>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="form-control form-control-lg" class="btn btn-success btn-block btn-lg">
                            </div>
                        </form>

                    </div>
                    @else
                    <div class="modal-body">

                        <form action="{{ route('admin.forum.create', ['categoryid'=> $category->id])}}" method="POST">

                            @csrf
                            <div class="form-group">
                                <input type="text" name="title" class="form-control form-control-lg" placeholder="Enter title" required>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="form-control form-control-lg" class="btn btn-success btn-block btn-lg">
                            </div>
                        </form>

                    </div>

                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection