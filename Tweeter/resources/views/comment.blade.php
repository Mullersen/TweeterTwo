@extends('layouts.app')

@section('content')

<p>Edit or Delete Your Comment</p>
{{$tweet->content}}
    <form action='/comment/editComment' method='POST'>
        @csrf
        <input type='hidden' name='author' value='{{Auth::user()->id}}'>
        <div><textarea id='content' cols='100' name='content'>{{$comment->content}}</textarea></div>
        <button name='id' value='{{$comment->id}}' type='submit'>Save comment</button>
    </form>
    <form action='/tweetFeed' method='get'>
        @csrf
        <button type='submit'>Go back</button>
    </form>

@endsection
