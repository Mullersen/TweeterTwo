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
    <form action="/addTweet" method="POST">
        @csrf
    <input type='hidden' name='user' value='{{Auth::user()->name}}'>
        <div><textarea id='content' cols='100' name='content'>Your Tweet</textarea></div>
        <input type='submit' name='submit' value='Save Tweet'>
    </form>


   @foreach ($tweets as $tweet)
        <div>{{$tweet->content}}</div>
        <div>{{App\Tweet::find($tweet->id)->user->name}}</div>
        @if (Auth::user()->id == $tweet->user_id)
            <form action="/tweet/showTweet" method="get">
                <button type="submit" name='id' value='{{$tweet->id}}'>Edit/Delete Tweet</button>
            </form>
        @endif
        @if (Auth::user()->id !== $tweet->user_id)
            @if (checkUser(App\Tweet::find($tweet->id)->user->name, $follows))
                <p>Already Following!</p>
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
        <br>
        <br>
    @endforeach
@endguest
@endsection
