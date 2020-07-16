<table class="table table-striped text-center">
    <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Date Of Birth</th>
            <th>Phone Number</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Last Updated</th>
            <th>Email Verified At</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->password}}</td>
            <td>{{$user->dob}}</td>
            <td>{{$user->number}}</td>
            <td>{{$user->role}}</td>
            <td>{{$user->created_at}}</td>
            <td>{{$user->updated_at}}</td>
            <td>{{$user->email_verified_at}}</td>
        </tr>
        @endforeach

    </tbody>
</table>