@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Profile Page -->
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        <div class="card-header bg-primary text-light text-center lead">
            YOUR PROFILE IMAGE|| <br>
            @if ($user->photo == NULL)
            <img src="{{asset('storage/default.png')}}" alt="Image" style="width:200px ;height:200px;">
            @else
            <img src="{{asset('storage/'.$user->name?? ''.'/'.$user->photo)}}" alt="Image" style="width:200px ;height:200px;">
            @endif
        </div>

        <div class="form-group">
            <label for="place">Your place</label>
            <p>{{$profile->place?? ''}}</p>
        </div>

        <div class=" form-group">
            <label for="job">Your Job</label>
            <p>{{$profile->job?? ''}}</p>
        </div>

        <div class=" form-group">
            <label for="personal_id">Your Personal ID</label>
            <p>{{$profile->personal_id?? ''}}</p>
        </div>

        <div class=" form-group">
            <label for="issued_date">Your Personal ID Issued Date</label>
            <p>{{$profile->issued_date?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="issued_by">Your Personal ID Issued By</label>
            <p>{{$profile->issued_by?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="supervisor_name">Your Supervisor Name ( Optional unless you are below 14 years old )</label>
            <p>{{$profile->supervisor_name?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="supervisor_dob">Your Supervisor Date Of Birth ( Optional unless you are below 14 years old )</label>
            <p>{{$profile->supervisor_dob?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="detail">Your Introduction</label>
            <p>{{$profile->detail?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="google_plus_name">Your Google Plus Name</label>
            <p>{{$profile->google_plus_name?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="google_plus_link">Your Google Plus Link</label>
            <p>{{$profile->google_plus_link?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="aim_link">Your A.I.M link</label>
            <p>{{$profile->aim_link?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="icq_link">Your ICQ Link</label>
            <p>{{$profile->icq_link?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="window_live_link">Your Window Live Link</label>
            <p>{{$profile->window_live_link?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="yahoo_link">Your Yahoo Link</label>
            <p>{{$profile->yahoo_link?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="skype_link">Your Skype Link</label>
            <p>{{$profile->skype_link?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="google_talk_link">Your Google Talk Link</label>
            <p>{{$profile->google_talk_link?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="facebook_link">Your Facebook Link</label>
            <p>{{$profile->facebook_link?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="twitter_link">Your Twitter Link</label>
            <p>{{$profile->twitter_link?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="created_at">Your Profile Created At</label>
            <p>{{$profile->created_at?? ''}}</p>
        </div>

        <div class="form-group">
            <label for="updated_at">Your Profiler Last Updated</label>
            <p>{{$profile->updated_at?? ''}}</p>
        </div>

        <!-- Profile Page -->
        @if(Auth::user()->id == $user->id)
        <div class="card border-secondary">
            <a href="{{ route('account.profile.edit', ['name'=> Auth::user()->name?? '','id'=> Auth::user()->id])}}" class="btn btn-info">Edit Profile</a>
        </div>
        @endif
    </div>
</div>

@endsection