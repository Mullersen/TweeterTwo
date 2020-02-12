@extends('layouts.app')

@section('content')
<div class="alert alert-danger" role="alert">
    Are you sure you want to delete the following tweet?
</div>
<div class="card mb-4">
    <div class="card-header">
        {{App\Tweet::find($tweet->id)->user->name}}
    </div>
    <div class="card-body">
        <p class="font-weight-bold">{{$tweet->content}}</p>
        <form action='/tweet/deleteTweet/yes' method='get'>
            @csrf
            <div class="form-group">
                <button class="form-control bg-light" type='submit' name='id' value='{{$tweet->id}}'>Yes</button>
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
