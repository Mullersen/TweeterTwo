@extends('layouts.app')

@section('content')

<p>Edit or Delete Your Post</p>
    <form action='/tweet/editTweet' method='POST'>
        @csrf
        <input type='hidden' name='author' value='{{Auth::user()->id}}'>
        <div><textarea id='content' cols='100' name='content'>{{$tweet->content}}</textarea></div>
    </form>
    <form action='/tweet/deleteTweet' method='post'>
        @csrf
        <button name='id' value='{{$tweet->id}}' type='submit'>Delete Tweet</button>
    </form>
    <form action='/tweetFeed' method='get'>
        @csrf
        <button type='submit'>Home</button>
    </form>

@if ($errors->any()) {{--if theform is not validated with the controller will send the user back to the previous view. Flash messages will be shown before the site if compiled. Flash data will be sent with the request and show built in error messages--}}
        @foreach ($errors->all() as $error)
            {{$error}}
        @endforeach
    @endif
@endsection
