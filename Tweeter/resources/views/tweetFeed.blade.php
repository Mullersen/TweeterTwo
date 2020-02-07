@extends('layouts.app')

@php // follows is all the rows in Follow where user_id matches the id of logged in user

    function checkUser($UserToCheck, $follows){
        //we have to pass in the variable $follows above, becuase in a function you dont have access to variables from outside the varibale, unless you pass it in specifically.
        foreach ($follows as $checkedUser) {
            if($checkedUser->followed_user == $UserToCheck){
                return true;
            }
        }
        return false;
    }
@endphp


@section('content')
@guest
  <p>Go log in to edit your tweets</p>

    @foreach ($tweets as $tweet)
        <div>{{$tweet->content}}</div>
        <div>{{App\Tweet::find($tweet->id)->user->name}}</div>
        <br>
        <br>
    @endforeach

@else
    <p> welcome {{Auth::user()->name}} </p> {{--We are using the auth class, which has a method called user. therefore we can access the user-object through the arrow--}}
    <p>Create new tweet</p>
    <form action="/tweet/addTweet" method="POST">
        @csrf
    <input type='hidden' name='user' value='{{Auth::user()->name}}'>
        <div><textarea id='content' cols='100' name='content'>Your Tweet</textarea></div>
        <input type='submit' name='submit' value='Save Tweet'>
    </form>
    <br>
    <br>


   @foreach ($tweets as $tweet)
        <div><h3>{{$tweet->content}}</h3></div>
        <div><h4>{{App\Tweet::find($tweet->id)->user->name}}</h4></div>
        @if (Auth::user()->id == $tweet->user_id)
            <form action="/tweet/showTweet" method="get">
                <button type="submit" name='id' value='{{$tweet->id}}'>Edit/Delete Tweet</button>
            </form>
        @endif
        @if (Auth::user()->id !== $tweet->user_id)
            @if (checkUser(App\Tweet::find($tweet->id)->user->name, $follows))
                <form action="/profile/unfollowUser" method="POST">
                    @csrf
                    <button name='name' value='{{App\Tweet::find($tweet->id)->user->name}}'>Unfollow User</button>
                </form>
            @else
                <form action="/profile/followUser" method="POST">
                    @csrf
                    <button name='name' value='{{App\Tweet::find($tweet->id)->user->name}}'>Follow User</button>
                </form>
            @endif
        @endif
        @foreach ($comments as $comment)
            @if ($comment->tweet_id == $tweet->id) {{--Show only the comments that belong to the tweet--}}
               <p><strong>{{$comment->content}}</strong></p>
                <p>{{\App\Comment::find($comment->id)->user->name}}</p>
                @if ($comment->user_id == Auth::user()->id) {{--If the comment belongs to the logged in user--}}
                <form action="/comment/deleteComment" method="POST">
                    @csrf
                    <button name='id' value='{{$comment->id}}'>Delete Comment</button>
                </form>
                <form action="/comment/showComment" method="POST">
                    @csrf
                    <button name='id' value='{{$comment->id}}'>Edit Comment</button>
                </form>
                @endif
            @endif
        @endforeach
        <form action="/comment/addComment" method="POST">
            @csrf
            <input type='hidden' name='user' value='{{Auth::user()->name}}'>
            <div><textarea id='content' cols='100' name='content'>Comment</textarea></div>
            <button name='id' value='{{$tweet->id}}'>Comment</button>
        </form>
        <br>
        <br>
        <br>
    @endforeach
@endguest
@endsection
