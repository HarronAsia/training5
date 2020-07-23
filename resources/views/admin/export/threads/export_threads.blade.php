@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="card-header" align="center">
            <a href="{{ route('admin.export.threads')}}" class="btn btn-success">
                <i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export thread
            </a>
            <hr>

        </div>
        <form method="post" action="{{ route('admin.import.threads')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="excel">Your Sheet file</label>
                <input type="file" class="form-control" name="excel">
            </div>
            <br />
            <button type="submit" class="btn btn-success">Import thread</button>
        </form>
        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <div class="card-body">
                    <div class="table-responsive" id="showBlog">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Title</th>
                                    <th>Owner ID</th>
                                    <th>Detail</th>
                                    <th>Created At</th>
                                    <th>Last Updated</th>
                                    <th>Thumbnail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($threads as $thread)
                                <tr>
                                    <td>{{$thread->id}}</td>
                                    <td>
                                        <div>
                                            {{$thread->title}}
                                        </div>
                                    </td>
                                    <td>{{$thread->user_id}}</td>
                                    <td>{{$thread->detail}}</td>
                                    <td>{{$thread->created_at}}</td>
                                    <td>{{$thread->updated_at}}</td>
                                    <td>
                                        @if ($thread->thumbnail == NULL)
                                        <img src="{{asset('storage/blank.png')}}" alt="Image" style="width:200px ;height:200px;">
                                        @else
                                        <img src="{{asset('storage/thread/'.$thread->title.'/'.$thread->thumbnail.'/')}}" alt="Image" style="width:200px ;height:200px;">
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
        {{$threads->links()}}
    </div>
</div>
@endsection