@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    You cannot access this page! This is for only '{{$role}}'"
                </div>
            </div>
        </div>
    </div>
</div>
@endsection