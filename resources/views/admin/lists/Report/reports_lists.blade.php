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
            All Reports
        </h3>


        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Reason</th>
                            <th>Detail</th>
                            <th>Where</th>
                            <th>Created At </th>
                            <th>Last Updated</th>
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                        <td>{{$report->id}}</td>
                        <td>{{$report->reason}}</td>
                        <th>{{$report->detail}}</th>
                        <th>{{$report->reportable_type}}</th>
                        <td>{{$report->created_at}}</td>
                        <td>{{$report->updated_at}}</td>
                        <td>{{$report->deleted_at}}</td>
                        <td>
                            @if($report->deleted_at != NULL)
                            <div class="pull-right">
                                <a href="{{ route('admin.report.restore', ['id'=> $report->id])}}">
                                    <button type="button" class="btn btn-success btn-lg">
                                        <i class="fa fa-undo"></i>
                                    </button>
                                </a>
                            </div>
                            @else
                            <div class="pull-right">
                                <a href="{{ route('admin.report.delete', ['id'=> $report->id])}}">
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
        {{$reports->links()}}
    </div>

</div>

@endsection