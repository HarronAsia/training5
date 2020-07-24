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

                            <th>
                                <a href="{{route('managers.threads.list')}}">
                                    Number of threads by Managers
                                </a>
                            </th>
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
                            <th>
                                <a href="/admin/{{Auth::user()->id}}/lists">
                                    Number of Admins
                                </a>
                            </th>
                            <th>
                                <a href="{{route('admins.threads.list')}}">
                                    Number of threads by Admins
                                </a>
                            </th>
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

    <div class="card border-primary">
        <hr>
        <h3 class="card-header bg-primary d-flex justify-content-between">
            Tags
        </h3>

        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{route('tags.admin.list')}}">
                                    Number of Tags
                                </a>
                            </th>
    
                        </tr>
                    </thead>
                    <tbody>
                        <td>
                            {{$tags}}
                        </td>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-primary">
        <hr>
        <h3 class="card-header bg-primary d-flex justify-content-between">
            Categories
        </h3>

        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{route('categories.admin.list')}}">
                                    Number of Categories
                                </a>
                            </th>
    
                        </tr>
                    </thead>
                    <tbody>
                        <td>
                            {{$categories}}
                        </td>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-primary">
        <hr>
        <h3 class="card-header bg-primary d-flex justify-content-between">
            Forums
        </h3>

        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{route('forums.admin.list')}}">
                                    Number of Forums
                                </a>
                            </th>
    
                        </tr>
                    </thead>
                    <tbody>
                        <td>
                            {{$forums}}
                        </td>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-primary">
        <hr>
        <h3 class="card-header bg-primary d-flex justify-content-between">
            Communities
        </h3>

        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{route('communities.admin.list')}}">
                                    Number of Communities
                                </a>
                            </th>
    
                        </tr>
                    </thead>
                    <tbody>
                        <td>
                            {{$communities}}
                        </td>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-primary">
        <hr>
        <h3 class="card-header bg-primary d-flex justify-content-between">
            Posts
        </h3>

        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{route('communities.admin.list')}}">
                                    Number of Posts
                                </a>
                            </th>
    
                        </tr>
                    </thead>
                    <tbody>
                        <td>
                            {{$posts}}
                        </td>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-primary">
        <hr>
        <h3 class="card-header bg-primary d-flex justify-content-between">
            Comments
        </h3>

        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{route('comments.admin.list')}}">
                                    Number of Comments
                                </a>
                            </th>
    
                        </tr>
                    </thead>
                    <tbody>
                        <td>
                            {{$comments}}
                        </td>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-primary">
        <hr>
        <h3 class="card-header bg-primary d-flex justify-content-between">
            Reports
        </h3>

        <div class="card-body">
            <div class="table-responsive" id="showBlog">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{route('reports.admin.list')}}">
                                    Number of Reports
                                </a>
                            </th>
    
                        </tr>
                    </thead>
                    <tbody>
                        <td>
                            {{$reports}}
                        </td>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection