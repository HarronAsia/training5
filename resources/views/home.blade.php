@extends('layouts.app')

@section('content')

@if(Auth::user()->email_verified_at == NULL)
<script>
    window.location = "/email/verify";
</script>
@else
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
                    @foreach($forums as $forum)
                    <li class="list-group-item">
                        <div>
                            <h4>{{$forum->title}}</h4>
                        </div>
                    </li>
                    @endforeach
                </ol>
            </li>
        </ol>
        @endforeach
        {{ $categories->links() }}
    </div>
</div>
@endif
@endsection