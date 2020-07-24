@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <h1>Harron.vm</h1>
        @if(Auth::user()->role == 'admin')
        <div class="text-right">
            <a href="{{ route('admin.category.add')}}">
                <button type="button" class="btn btn-primary">Add Category</button>
            </a>
        </div>
        @else

        @endif
        @foreach($categories as $category)
        <ol class="list-group">


            @if(Auth::user()->role == "admin")
            <li class="list-group-item">
                <div>

                    <div class="bg-danger text-dark" style="font-size: 25px;">
                        <a href="{{ route('category.index', ['id'=> $category->id])}}">
                            {{$category->name}}
                        </a>
                        @if($category->deleted_at != NULL)
                        <div class="pull-right">
                            <a href="{{ route('admin.category.restore', ['id'=> $category->id])}}">
                                <button type="button" class="btn btn-success btn-lg">
                                    <i class="fa fa-undo"></i>
                                </button>
                            </a>
                        </div>
                        @else
                        <div class="pull-right">
                            <a href="{{ route('admin.category.edit', ['id'=> $category->id])}}">
                                <button type="button" class="btn btn-info btn-lg">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('admin.category.delete', ['id'=> $category->id])}}">
                                <button type="button" class="btn btn-danger btn-lg">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </a>
                        </div>
                        @endif
                    </div>

                    <div class="bg-danger text-dark" style="font-size: 15px;">
                        {{$category->detail}}

                    </div>

                </div>

                <ol class="list-group">
                    @foreach($category->forums as $forum)
                    <li class="list-group-item">
                        <div>
                            <a href="{{ route('thread.show', ['id'=> $forum->id])}}">
                                <h4>{{$forum->title}}</h4>
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ol>
            </li>

        </ol>
        @else
            @if($category->deleted_at != NULL)

            @else
                <li class="list-group-item">
                        <div>

                            <div class="bg-danger text-dark" style="font-size: 25px;">
                                <a href="{{ route('category.index', ['id'=> $category->id])}}">
                                    {{$category->name}}
                                </a>
                            </div>

                            <div class="bg-danger text-dark" style="font-size: 15px;">
                                {{$category->detail}}

                            </div>

                        </div>

                        <ol class="list-group">
                            @foreach($category->forums as $forum)
                            <li class="list-group-item">
                                <div>
                                    <a href="{{ route('thread.show', ['id'=> $forum->id])}}">
                                        <h4>{{$forum->title}}</h4>
                                    </a>
                                </div>
                            </li>
                            @endforeach
                        </ol>
                    </li>

                </ol>
            @endif
            
        @endif


        @endforeach
        {{ $categories->links() }}
    </div>
</div>

@endsection