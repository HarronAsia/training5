@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">

        <h1>All Unread Messages</h1>
        <div class="pull-right">
            <a href="{{ route('notification.read.all')}}">
                <button class="btn btn-danger">
                    Read All
                </button>
            </a>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allnotifications as $singlenotification)
                <tr>

                    <td>{{$singlenotification->id}}</td>
                    <td>{{json_decode($singlenotification->data)->data}}</td>
                    <td>{{$singlenotification->created_at}}</td>
                    <td>
                        <a href="{{ route('notification.read', ['id'=> $singlenotification->id])}}">
                            <button class="btn btn-danger">
                                &times;
                            </button>
                        </a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection