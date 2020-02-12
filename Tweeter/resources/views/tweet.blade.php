@extends('layouts.app')

@section('content')
    <h4 class="text-center mb-4">Edit or Delete your tweet here</h4>
        <form action='/tweet/editTweet' method='POST'>
            @csrf
            <input type='hidden' name='author' value='{{Auth::user()->id}}'>
            <div class="form-group">
                <div><textarea class="form-control" id='content' rows="5" name='content'>{{$tweet->content}}</textarea></div>
            </div>
            <div class="form-group">
                <button class="form-control bg-light" name='id' value='{{$tweet->id}}' type='submit'>Save Changes</button>
            </div>
        </form>
        <form action='/tweet/deleteTweet' method='post'>
            @csrf
            <div class="form-group">
                <button class="form-control bg-light" name='id' value='{{$tweet->id}}' type='submit'>Delete Tweet</button>
            </div>
        </form>

        @if ($errors->any()) {{--if theform is not validated with the controller will send the user back to the previous view. Flash messages will be shown before the site if compiled. Flash data will be sent with the request and show built in error messages--}}
            @foreach ($errors->all() as $error)
                {{$error}}
            @endforeach
        @endif
@endsection
