@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="container">
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h4 class="modal-title text-light">Add Thread</h4>
                    </div>

                    <div class="modal-body">

                        @if(Auth::user()->role == 'manager')
                        <form action="{{ route('manager.thread.add.confirm',['id'=>$forum->id])}}" method="POST" enctype="multipart/form-data">
                            @elseif(Auth::user()->role == 'admin')
                            <form action="{{ route('admin.thread.add.confirm',['id'=>$forum->id])}}" method="POST" enctype="multipart/form-data">
                                @else
                                <form action="{{ route('member.thread.add.confirm',['id'=>$forum->id])}}" method="POST" enctype="multipart/form-data">
                                @endif

                                @csrf
                                <div class="form-group">
                                    <input type="text" name="title" class="form-control form-control-lg" placeholder="Enter Title" required>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="detail" class="form-control form-control-lg" placeholder="Enter Detail" required>
                                </div>

                                <div class="form-group">
                                    <label for="tag_id" class="col-md-4 control-label">Tag:</label>
                                    <select class="form-control" name="tag_id" id="tag_id">
                                        @foreach($tags as $tag)
                                        <option value="{{$tag->id}}">{{ucfirst(trans($tag->name))}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">

                                    <img id="image_preview_container" src="{{asset('storage/blank.png')}}" alt="preview Banner" style="max-width: 500px ; max-height:500px;">
                                    <div>
                                        <label for="thumbnail">Upload Your Banner image</label>
                                        <input type="file" class="form-control" name="thumbnail" id="thumbnail">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="status" class="col-md-4 control-label">Status:</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="public">Public</option>
                                        <option value="private">Private</option>
                                    </select>
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