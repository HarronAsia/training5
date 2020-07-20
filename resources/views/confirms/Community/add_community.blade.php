@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

        <div class="container">
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h4 class="modal-title text-light">Add Community</h4>
                    </div>

                    <div class="modal-body">

                        <form action="{{ route('admin.community.create')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="title" class="form-control form-control-lg" placeholder="Enter Title" required>
                            </div>

                            <div class="form-group">

                                    <img id="image_preview_container" src="{{asset('storage/blank.png')}}" alt="preview Banner" style="max-width: 500px ; max-height:500px;">
                                    <div>
                                        <label for="banner">Upload Your Banner image</label>
                                        <input type="file" class="form-control" name="banner" id="banner" required>
                                    </div>
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