@extends('layouts.app')

@section('content')
    <h4 class="text-center mb-4">Edit or Delete your tweet here</h4>
        <form action='/tweet/editTweet' method='POST'>
            @csrf
            <input type='hidden' name='author' value='{{Auth::user()->id}}'>
            <div class="form-group">
                <h5 class="card-subtitle text-muted"><a href="/profile/show/{{{$tweet->user_id}}}">@ {{App\Tweet::find($tweet->id)->user->name}}</a></h5>
                @if ($tweet->is_retweet == 1)
                <div><textarea class="form-control" id='content' rows="5" name='content'>{{$tweet->content}}</textarea></div>
                        <div class="card my-3">
                            <div class="card-body bg-light">
                                <p class="card-subtitle mb-2">{{$tweet->original_author}}</p>
                                <p class="card-text text-muted mb-2">{{$tweet->original_content}}</p>
                            </div>
                        </div>
                @else
                    <p class="card-text mb-2">{{$tweet->content}}</p>
                @endif
            </div>
            <div class="form-group">
                <button class="form-control bg-light" name='id' value='{{$tweet->id}}' type='submit'>Save Changes</button>
            </div>
        </form>
        <form action='/tweet/deleteTweet' method='post'>
            @csrf
            <div class="form-group">
                <button class="form-control bg-light btn btn-outline-danger" name='id' value='{{$tweet->id}}' type='submit'>Delete Tweet</button>
            </div>
        </form>

        @if ($errors->any()) {{--if theform is not validated with the controller will send the user back to the previous view. Flash messages will be shown before the site if compiled. Flash data will be sent with the request and show built in error messages--}}
            @foreach ($errors->all() as $error)
                {{$error}}
            @endforeach
        @endif
@endsection
