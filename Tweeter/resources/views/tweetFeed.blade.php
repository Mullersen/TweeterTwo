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
        <h5>New Tweet</h5>
        <form action="/tweet/addTweet" method="GET">
            @csrf
            <input class="form-control" type='hidden' name='name' value='{{Auth::user()->name}}'>
            <div class="form-group">
            <textarea class="form-control" id='content' name='content' placeholder="Share something interesting...">{{old('content')}}</textarea>
            </div>
            @if ($errors->any()) {{--if theform is not validated with the controller will send the user back to the previous view. Flash messages will be shown before the site if compiled. Flash data will be sent with the request and show built in error messages--}}
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
        <div class="row mb-4 justify-content-center">
            <div class="col-md-6">
                @foreach ($tweets as $tweet){{--everything below here is part of the foreach loop showing the tweets--}}
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
                            {{--Follow/unfollow--}}
                            @if (Auth::user()->id !== $tweet->user_id)
                                @if (checkUser(App\Tweet::find($tweet->id)->user->name, $follows)){{--check all the current followed authors against the current tweets author--}}
                                    <form class="mr-auto" action="/profile/unfollowUser" method="POST"style="display:inline">
                                        @csrf
                                        <button class="btn btn-outline-primary btn-sm mb-3"  name='name' value='{{App\Tweet::find($tweet->id)->user->name}}'>Unfollow User</button>
                                    </form>
                                @else
                                    <form action="/profile/followUser" method="POST"style="display:inline">
                                        @csrf
                                        <button class="btn btn-outline-primary btn-sm mb-3"  name='name' value='{{App\Tweet::find($tweet->id)->user->name}}'>Follow User</button>
                                    </form>
                                @endif
                            @endif
                            {{--Like option--}}
                            @if (checkTweet($tweet->id, $likes))
                                <form action="like/likeTweet" method="POST" style="display:inline">
                                    @csrf
                                    <button class="btn btn-outline-primary btn-sm mb-3"  name='id' value='{{$tweet->id}}'>
                                        Like <span class="badge badge-pill badge-secondary">{{App\Tweet::find($tweet->id)->like->count()}}</span>
                                    </button>
                                </form>
                            @else
                                <form action="like/unlikeTweet" method="POST" style="display:inline">
                                    @csrf
                                    <button class="btn btn-outline-primary btn-sm mb-3"  name='id' value='{{$tweet->id}}'>
                                        Unlike <span class="badge badge-pill badge-secondary">{{App\Tweet::find($tweet->id)->like->count()}}</span>
                                    </button>
                                </form>
                            @endif
                            {{--Show only the comments that belongs to the tweet--}}
                            @foreach ($comments as $comment)
                                @if ($comment->tweet_id == $tweet->id)
                                    <div class="container mb-2">
                                        <p class="card-text small mb-1 font-weight-bold">{{\App\Comment::find($comment->id)->user->name}}</p>
                                        <p class="card-text small mb-2 border-bottom">- {{$comment->content}}</p>
                                    {{--Edit comment it belongs to the logged in user--}}
                                        @if ($comment->user_id == Auth::user()->id)
                                            <form action="/comment/deleteComment" method="POST" style="display:inline">
                                                @csrf
                                                <button class="btn btn-link btn-sm"  name='id' value='{{$comment->id}}'>Delete Comment</button>
                                            </form>
                                            <form action="/comment/showComment" method="POST" style="display:inline">
                                                @csrf
                                                <button class="btn btn-link btn-sm"  name='id' value='{{$comment->id}}'>Edit Comment</button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                            {{--add comment to tweet--}}
                                <form class="form-inline mt-3" action="/comment/addComment" method="POST">
                                    @csrf
                                    <input type='hidden' name='user' value='{{Auth::user()->name}}'>
                                    <div class="form-group mb-0">
                                        <textarea class="form-control form-control-sm rounded-pill" style="width: 100%" rows="1" id='content' name='content'></textarea>
                                    </div>
                                    <button class="btn btn-primary btn-sm ml-2 rounded-pill"  name='id' value='{{$tweet->id}}'>Comment</button>
                                </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endguest

@endsection
