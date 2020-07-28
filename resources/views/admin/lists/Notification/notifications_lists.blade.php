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
            All Notifications
        </h3>


        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Notification Type</th>
                            <th>Where</th>
                            <th>ID</th>
                            <th>Data At </th>
                            <th>Created At</th>
                            <th>Read At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($Allnotifications as $singlenotification)
                            <td>{{$singlenotification->id}}</td>
                            <td>{{$singlenotification->type}}</td>
                            <th>{{$singlenotification->notifiable_type}}</th>
                            <th>{{$singlenotification->notifiable_id}}</th>
                            <td>{{json_decode($singlenotification->data)->data}}</td>
                            <td>{{$singlenotification->created_at}}</td>
                            <td>{{$singlenotification->read_at}}</td>
                            <td>
                                <div class="pull-right">
                                    <a href="{{ route('admin.notification.delete', ['id'=> $singlenotification->id])}}">
                                        <button type="button" class="btn btn-danger btn-lg">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        {{$Allnotifications->links()}}
    </div>

</div>

@endsection