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
    echo($tweets);
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
        <div class="row mb-4 justify-content-center" id="tweet-vue">
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
                                    <div class="row align-items-center">
                                        <div class="col-4 text-center">
                                            <Like tweetid={{ $tweet->id }} likeCount={{App\Tweet::find($tweet->id)->like->count()}}></Like>
                                        </div>
                                        <div class="col-4 text-center">
                                            @include('partials.followUnfollow')
                                        </div>
                                        @if ($tweet->is_retweet ==0)
                                            <div class="col-4 text-center">
                                                <Myretweet retweetid="{{ $tweet->id }}" retweetcontent="{{$tweet->content}}" retweetauthor="{{App\Tweet::find($tweet->id)->user->name}}"/>
                                            </div>
                                        @endif
                                    </div>
                                @include('partials.tweetComment')
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endguest
    {{ $tweets->links() }}

@endsection
