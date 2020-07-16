@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">


        <div class="col-lg-12">

            <h4 class="text-center text-primary mt-2"> Harron the Intern </h4>
        </div>
    </div>

    <div class="card border-primary">

        <hr>
        <h3 class="card-header bg-primary d-flex justify-content-between">

            User
        </h3>


        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th><a href="/admin/member/lists">Number of Users</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <td>
                            {{$users}}
                        </td>

                    </tbody>
                </table>

            </div>
        </div>

    </div>

    <div class="card border-primary">

        <hr>
        <h3 class="card-header bg-primary d-flex justify-content-between">
            Manager
        </h3>


        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th><a href="/admin/manager/lists">Number of Managers</a></th>
                            <th>Number of threads by Managers</th>

                        </tr>
                    </thead>
                    <tbody>

                        <td>
                            {{$managers}}
                        </td>

                        <td>
                            {{$managers_threads}}
                        </td>


                    </tbody>
                </table>

            </div>
        </div>

    </div>

    <div class="card border-primary">
        <hr>
        <h3 class="card-header bg-primary d-flex justify-content-between">
            Admins
        </h3>

        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th><a href="/admin/lists">Number of Admins</a></th>
                            <th>Number of threads by Admins</th>

                        </tr>
                    </thead>
                    <tbody>
                        <td>
                            {{$admins}}
                        </td>

                        <td>
                            {{$admins_threads}}
                        </td>



                    </tbody>
                </table>

            </div>
        </div>

    </div>

</div>
@endsection