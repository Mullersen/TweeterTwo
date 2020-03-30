@extends('layouts.app')

@php // $follows is all the rows in Follow where user_id matches the id of logged in user

    function checkUser($userToCheck, $follows){
        //we have to pass in the variable $follows above, becuase in a function you dont have access to variables from outside the varibale, unless you pass it in specifically.
        foreach ($follows as $checkedUser) {
            if($checkedUser->followed_user == $userToCheck){
                return true;
            }
        }
        return false;
    }
    //$likes are all the rows in Likes where user_id matches Auth::user()->id.
    function checkTweet($tweetToCheck, $likes){
        foreach($likes as $checkedTweet){
            if($checkedTweet->tweet_id == $tweetToCheck){
                return false;
            }
        } return true;
    }
@endphp


@section('content')
    @guest
        <div class="alert alert-secondary text-center" role="alert">
            Log in to tweet, edit, and follow
        </div>
        <hr>
        <div class="row mb-4 justify-content-center">
            <div class="col-md-6">
                @foreach ($tweets as $tweet)
                    <div class="card mb-4">
                        <div class="card-body">
                            <p class="card-text mb-2">{{$tweet->content}}</p>
                            <hr>
                            <h5 class="card-subtitle text-muted"><a class="card-link" href="/profile/show/{{{$tweet->user_id}}}">{{App\Tweet::find($tweet->id)->user->name}}</a></h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div>
        {{--Welcome message--}}
        <div class="alert alert-info text-center" role="alert">
            Welcome {{Auth::user()->name}}! {{--We are using the auth class, which has a method called user. therefore we can access the user-object through the arrow--}}
        </div>
        <hr>
        {{--Create new Tweet--}}
        <img class="mb-1" style="display:inline" height="40px" src="{{url('/images/bird.png')}}" alt="Bird">
        <h5 style="display:inline">Tweet @ {{Auth::user()->name}}</h5>
        <form action="/tweet/addTweet" method="GET">
            @csrf
            <input class="form-control" type='hidden' name='name' value='{{Auth::user()->name}}'>
            <div class="form-group">
            <textarea class="form-control" id='content' name='content' placeholder="Share something interesting...">{{old('content')}}</textarea>
            </div>
            @if ($errors->any()) {{--if theform is not validated with the controller, it will send the user back to the previous view. Flash messages will be shown before the site if compiled. Flash data will be sent with the request and show built in error messages--}}
                @foreach ($errors->all() as $error)
                <div class="alert alert-warning text-center" role="alert">
                    {{$error}}
                </div>
                @endforeach
            @endif
            <button class="form-control"  name='id' value='{{Auth::user()->id}}'>Post Tweet</button>
        </form>
        <hr>
        {{--Show tweets--}}
        <div class="row mb-4 justify-content-center" id="tweet-like">
            <div class="col-md-6">
                @foreach ($tweets as $tweet){{--everything below here is part of the foreach loop showing the tweets--}}
                    @if (checkUser(App\Tweet::find($tweet->id)->user->name, $follows) or Auth::user()->id == $tweet->user_id)
                        <div class="card mb-2">
                            <div class="card-body">
                                {{--Edit Tweet if owner--}}
                                @if (Auth::user()->id == $tweet->user_id)
                                    <form class="float-right" action="/tweet/showTweet" method="get">
                                        <button class="btn btn-link btn-sm mb-2"  type="submit" name='id' value='{{$tweet->id}}'>Edit/Delete Tweet</button>
                                    </form>
                                @endif
                                {{--Show the tweet and author--}}
                                    <h5 class="card-subtitle text-muted"><a href="/profile/show/{{{$tweet->user_id}}}">{{App\Tweet::find($tweet->id)->user->name}}</a></h5>
                                    <p class="card-text mb-2">{{$tweet->content}}</p>
                                    <p class="card-text font-italic small mb-2">{{$tweet->created_at->diffForHumans()}}</p>

                                <Like :tweetid="{{ $tweet->id }}"></Like>
                                @include('partials.followUnfollow')
                                @include('partials.tweetComment')
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endguest

@endsection
