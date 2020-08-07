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
<div id="tweet-vue" class="row mb-4 justify-content-center">
    <div class="col-md-6">
        <h3 class="text-center mb-4">Discover new users and tweets</h3>
        <hr>
        @foreach ($tweets as $tweet)
        @if (!checkUser(App\Tweet::find($tweet->id)->user->name, $follows) and Auth::user()->id !== $tweet->user_id)
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-subtitle text-muted"><a href="/profile/show/{{{$tweet->user_id}}}">@ {{App\Tweet::find($tweet->id)->user->name}}</a></h5>
                        @if ($tweet->is_retweet == 1)
                            <p class="card-text mb-2">{{$tweet->content}}</p>
                            <div class="card my-3">
                                <div class="card-body bg-light">
                                    <p class="card-subtitle mb-2">{{$tweet->original_author}}</p>
                                    <p class="card-text text-muted mb-2">{{$tweet->original_content}}</p>
                                </div>
                            </div>
                        @else
                            <p class="card-text mb-2">{{$tweet->content}}</p>
                        @endif
                    <p class="card-text font-italic small mb-2">{{$tweet->created_at->diffForHumans()}}</p>
                    <div class="btn-toolbar">
                        <div class="btn-group mr-2">
                            @include('partials.followUnfollow')
                        </div>
                        <div class="btn-toolbar">
                            <Like tweetid={{ $tweet->id }} likeCount={{App\Tweet::find($tweet->id)->like->count()}}></Like>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @endforeach
    </div>
</div>
{{ $tweets->setPath('/discoveryFeed') }}
@endsection
