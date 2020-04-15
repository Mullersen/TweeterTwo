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
        <svg class="mb-1"xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="height: 50px; "><defs><filter id="shadow-1" height="300%" width="300%" x="-100%" y="-100%"><feFlood flood-color="rgba(255, 255, 255, 1)" result="flood"></feFlood><feComposite in="flood" in2="SourceGraphic" operator="atop" result="composite"></feComposite><feGaussianBlur in="composite" stdDeviation="15" result="blur"></feGaussianBlur><feOffset dx="1" dy="1" result="offset"></feOffset><feComposite in="SourceGraphic" in2="offset" operator="over"></feComposite></filter></defs><g class="" transform="translate(0,0)" style="touch-action: none;"><path d="M96.18 22.49C264.6 98.36 403.1 214.8 40.11 270.5 153 268 191.6 291.1 64.12 382.6c230.18-128 331.68-189 318.98 106.9 30.5-54.4 114.6-241 36.4-268.3 6.2-7.4 15.5-19.4 22.1-31.9 13.1-5.7 22.6-13.6 30.3-23.7-8.7-2-16-2.5-22.8-2.3-.2-2.8-.8-5.5-2.1-7.9-8.7-16.5-48.1-13.7-62.4-12.1 4.7-81-226.8-117.09-288.42-120.81z" fill="#ecd444" transform="translate(0, 0) scale(1, 1) rotate(45, 256, 256)" fill-opacity="1" filter="url(#shadow-1)"></path></g></svg>
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
            <div id="tweetGrid" class="col-md-6">
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
                                                <Myretweet username={{ Auth::user()->name}} retweetcontent="{{$tweet->content}}" retweetauthor="{{App\Tweet::find($tweet->id)->user->name}}"/>
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
