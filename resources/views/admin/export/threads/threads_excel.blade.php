<table class="table table-striped text-center">
    <thead>
        <tr>
            <th>No.</th>
            <th>Title</th>
            <th>Owner ID</th>
            <th>Detail</th>
            <th>Created At</th>
            <th>Last Updated</th>
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
        </tr>
        @endforeach
    </tbody>
</table>