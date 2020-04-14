@extends('layouts.app')

@section('content')
<div class="alert alert-danger" role="alert">
    Are you sure you want to delete the following tweet and all its comments?
</div> 
<div class="card mb-4">
    <div class="card-body">
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
