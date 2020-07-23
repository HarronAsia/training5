@extends('layouts.app')

@section('content')
@foreach($profile as $value)
@if(Auth::user()->id != $value->user_id)

@else
<div class="container-fluid">
    <div class="row">
        <!-- Profile Page -->
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        <div class="card-header bg-primary text-light text-center lead">
            YOUR PROFILE IMAGE|| <br>
            @if ($user->photo == NULL)
            <img src="{{asset('storage/default.png')}}" alt="Image" style="width:200px ;height:200px;">
            @else
            <img src="{{asset('storage/'.Auth::user()->name.'/'.Auth::user()->photo)}}" alt="Image" style="width:200px ;height:200px;">
            @endif
        </div>

        <form action="{{ route('account.profile.update', ['id' => $value->id ])}}" method="POST" >
            @csrf

            <div class="form-group">
                <label for="place">Your place</label>
                <input type = "text" class="form-control" name="place" placeholder="Enter Your Place" value="{{$value->place}}">
            </div>

            <div class=" form-group">
                <label for="job">Your Job</label>
                <input type = "text" class="form-control" name="job" placeholder="Enter Your Job" value="{{$value->job}}">
            </div>

            <div class=" form-group">
                <label for="personal_id">Your Personal ID</label>
                <input type = "text" class="form-control" name="personal_id" placeholder="Enter Your Personal ID" value="{{$value->personal_id}}">
            </div>

            <div class=" form-group">
                <label for="issued_date">Your Personal ID Issued Date</label>
                <input type = "date" class="form-control" name="issued_date" placeholder="Enter Your Personal ID Issued Date" value="{{$value->issued_date}}">
            </div>

            <div class="form-group">
                <label for="issued_by">Your Personal ID Issued By</label>
                <input type = "text" class="form-control" name="issued_by" placeholder="Enter Your Personal ID Issued By" value="{{$value->issued_by}}">
            </div>

            <div class="form-group">
                <label for="supervisor_name">Your Supervisor Name ( Optional unless you are below 14 years old )</label>
                <input type = "text" class="form-control" name="supervisor_name" placeholder="Enter Your Supervisor Name" value="{{$value->supervisor_name}}">
            </div>

            <div class="form-group">
                <label for="supervisor_dob">Your Supervisor Date Of Birth ( Optional unless you are below 14 years old )</label>
                <input type = "date" class="form-control" name="supervisor_dob" placeholder="Enter Your Supervisor Dob" value="{{$value->supervisor_dob}}">
            </div>

            <div class="form-group">
                <label for="detail">Your Introduction</label>
                <input type = "text" class="form-control" name="detail" placeholder="Enter your Introduction" value="{{$value->detail}}">
            </div>

            <div class="form-group">
                <label for="google_plus_name">Your Google Plus Name</label>
                <input type = "text" class="form-control" name="google_plus_name" placeholder="Enter your Google Plus Name" value="{{$value->google_plus_name}}">
            </div>

            <div class="form-group">
                <label for="google_plus_link">Your Google Plus Link</label>
                <input type = "text" class="form-control" name="google_plus_link" placeholder="Enter your Google Plus Link" value="{{$value->google_plus_link}}">
            </div>

            <div class="form-group">
                <label for="aim_link">Your A.I.M link</label>
                <input type = "text" class="form-control" name="aim_link" placeholder="Enter your AIM Link" value="{{$value->aim_link}}">
            </div>

            <div class="form-group">
                <label for="icq_link">Your ICQ Link</label>
                <input type = "text" class="form-control" name="icq_link" placeholder="Enter your ICQ Link" value="{{$value->icq_link}}">
            </div>

            <div class="form-group">
                <label for="window_live_link">Your Window Live Link</label>
                <input type = "text" class="form-control" name="window_live_link" placeholder="Enter your Window Live Link" value="{{$value->window_live_link}}">
            </div>

            <div class="form-group">
                <label for="yahoo_link">Your Yahoo Link</label>
                <input type = "text" class="form-control" name="yahoo_link" placeholder="Enter your Yahoo Link" value="{{$value->yahoo_link}}">
            </div>

            <div class="form-group">
                <label for="skype_link">Your Skype Link</label>
                <input type = "text" class="form-control" name="skype_link" placeholder="Enter your Skype Link" value="{{$value->skype_link}}">
            </div>

            <div class="form-group">
                <label for="google_talk_link">Your Google Talk Link</label>
                <input type = "text" class="form-control" name="google_talk_link" placeholder="Enter your Google Talk Link" value="{{$value->google_talk_link}}">
            </div>

            <div class="form-group">
                <label for="facebook_link">Your Facebook Link</label>
                <input type = "text" class="form-control" name="facebook_link" placeholder="Enter your Face Book Link" value="{{$value->facebook_link}}">
            </div>

            <div class="form-group">
                <label for="twitter_link">Your Twitter Link</label>
                <input type = "text" class="form-control" name="twitter_link" placeholder="Enter your Twitter Link" value="{{$value->twitter_link}}">
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <!-- Profile Page -->
    </div>
</div>
@endif
@endforeach
@endsection