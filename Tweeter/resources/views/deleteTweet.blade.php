@extends('layouts.app')

@section('content')
<div class="alert alert-danger" role="alert">
    Are you sure you want to delete the following tweet and all its comments?
</div>
<div class="card mb-4">
    <div class="card-header">
        {{App\Tweet::find($tweet->id)->user->name}}
    </div>
    <div class="card-body">
            <p class="font-weight-bold">{{$tweet->content}}</p>
            @foreach ($comments as $comment)
                @if ($comment->tweet_id == $tweet->id)
                    <div class="container mb-2">
                    <p class="card-text small mb-1 font-weight-bold">{{\App\Comment::find($comment->id)->user->name}}</p>
                    <p class="card-text small mb-2 border-bottom">- {{$comment->content}}</p>
                    </div>
                @endif
            @endforeach
        <form action='/tweet/deleteTweet/yes' method='get'>
            @csrf
            <div class="form-group">
                <button class="form-control btn btn-outline-danger" type='submit' name='id' value='{{$tweet->id}}'>Yes</button>
            </div>
        </form>
        <form action='/tweet/showTweet' method='get'>
            @csrf
            <div class="form-group">
                <button class="form-control bg-light" type='submit'name='id' value='{{$tweet->id}}'>No, take me back</button>
            </div>
        </form>
    </div>
</div>
@endsection
