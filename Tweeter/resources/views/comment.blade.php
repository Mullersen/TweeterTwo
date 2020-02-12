@extends('layouts.app')

@section('content')
<h4 class="text-center mb-4">Edit or Delete Your Comment</h4>
{{$tweet->content}}
    <form action='/comment/editComment' method='POST'>
        @csrf
        <input type='hidden' name='author' value='{{Auth::user()->id}}'>
        <div class="form-group">
            <textarea class="form-control" id='content' cols='100' name='content'>{{$comment->content}}</textarea>
        </div>
        <div class="form-group">
            <button class="form-control bg-light" name='id' value='{{$comment->id}}' type='submit'>Save comment</button>
        </div>
    </form>
    <form action='/tweetFeed' method='get'>
        @csrf
        <button class="form-control bg-light" type='submit'>Go back</button>
    </form>

@endsection
