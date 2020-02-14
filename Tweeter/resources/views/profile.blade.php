@extends('layouts.app')

@section('content')
@guest
    <h3 class="text-center mb-4">{{$user->name}}'s profile</h3>
    <hr>
    @if ($tweets->isEmpty())
        <h5 class="text-center mb-2">This user has no tweets yet...</h5>
    @else
        <ul class="list-group">
            <li class="list-group-item active"><h5>{{$user->name}}'s tweets</h5></li>
            @foreach ($tweets as $tweet)
                <li class="list-group-item">{{$tweet->content}}</li>
            @endforeach
        </ul>
@endif
@else
    <h3 class="text-center mb-4">Your profile {{$user->name}}</h3>
    <hr>
    <div class="row mb-4 justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Username: {{$user->name}}</h3>
            <h4 class="text-center mb-4"> Email: {{$user->email}}</h4>
            <h4 class="text-center mb-4"> Created at: {{$user->created_at}}</h4>

            @if ($user == Auth::user())
                <form action='/profile/editEmail' method='POST'>
                    @csrf
                    <input type='hidden' name='id' value='{{$user->id}}'>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" id="email" placeholder="New Email Address">
                    </div>
                    @error('email') {{$message}} @enderror
                    <button class="form-control" type='submit'>Update Email</button>
                </form>
                <hr>
                <form action='/profile/editPassword' method='POST'>
                    @csrf
                    <input type='hidden' name='id' value='{{$user->id}}'>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" id="password" placeholder="New Password" required autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password_confirmation" id="password-confirm" placeholder="Confirm New Password" required autocomplete="new-password">
                    </div>
                    @error('password') {{$message}} @enderror
                    <button class="form-control mb-3" type='submit'>Update Password</button>
                </form>
            @endif
        </div>
    </div>

    @if ($follows->isEmpty())
        <a class="btn btn-outline-primary" role="button" href="/tweetFeed">Go follow some new users!</a>
    @else
        <ul class="list-group">
            <li class="list-group-item active"><h5>You are following</h5></li>
            @foreach ($follows as $follow)
                    <li class="list-group-item">{{$follow->followed_user}}</li>
            @endforeach
        </ul>
    @endif
    <hr>
    @if ($tweets->isEmpty())
        <a class="btn btn-outline-primary" role="button" href="/tweetFeed">Go make some new tweets!</a>
    @else
        <ul class="list-group">
            <li class="list-group-item active"><h5>Your tweets</h5></li>
            @foreach ($tweets as $tweet)
                <li class="list-group-item">{{$tweet->content}}</li>
            @endforeach
        </ul>
    @endif
@endguest

@endsection
