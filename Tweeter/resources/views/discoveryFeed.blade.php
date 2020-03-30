@extends('layouts.app')

@php
    function checkUser($userToCheck, $follows){
            //we have to pass in the variable $follows above, becuase in a function you dont have access to variables from outside the varibale, unless you pass it in specifically.
            foreach ($follows as $checkedUser) {
                if($checkedUser->followed_user == $userToCheck){
                    return true;
                }
            }
            return false;
        }
    function checkTweet($tweetToCheck, $likes){
        foreach($likes as $checkedTweet){
            if($checkedTweet->tweet_id == $tweetToCheck){
                return false;
            }
        } return true;
    }
@endphp


@section('content')
<div id="tweet-like" class="row mb-4 justify-content-center">
    <div class="col-md-6">
        <h3 class="text-center mb-4">Discover new users and tweets</h3>
        <hr>
        @foreach ($tweets as $tweet)
        @if (!checkUser(App\Tweet::find($tweet->id)->user->name, $follows) and Auth::user()->id !== $tweet->user_id)
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-subtitle text-muted"><a href="/profile/show/{{{$tweet->user_id}}}">{{App\Tweet::find($tweet->id)->user->name}}</a></h5>
                    <p class="card-text mb-2">{{$tweet->content}}</p>
                    <p class="card-text font-italic small mb-2">{{$tweet->created_at->diffForHumans()}}</p>
                    @include('partials.followUnfollow')
                    <Like :tweetid="{{ $tweet->id }}"></Like>
                </div>
            </div>
        @endif
        @endforeach
    </div>
</div>
@endsection
