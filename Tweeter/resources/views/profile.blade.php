@extends('layouts.app')

@section('content')

@if ($user == Auth::user())
<form action='/profile/editEmail' method='POST'>
    @csrf
    <input type='hidden' name='id' value='{{$user->id}}'>
    <input type="email" name="email" id="email">
    <div><button type='submit'>Edit Email</button></div>
</form>
<form action='/profile/editPassword' method='POST'>
    @csrf
    <input type='hidden' name='id' value='{{$user->id}}'>
    <input type="password" name="password" id="password" required autocomplete="new-password">
    <input type="password" name="password_confirmation" id="password-confirm" required autocomplete="new-password">
    @error('password') {{$message}} @enderror
    <div><button type='submit'>Edit Password</button></div>
@endif

@guest
<h1>{{$user->name}}</h1>
    @foreach ($tweets as $tweet)
    <div>{{$tweet->content}}</div>
    <br>
    <br>
    @endforeach
<form action='/tweetFeed' method='get'>
    @csrf
    <button type='submit'> Go back</button>
</form>
@else
<h1>{{$user->name}}</h1>
<h3>{{$user->email}}</h3>
<h3>{{$user->created_at}}</h3>

@foreach ($follows as $follow)
    <div>{{$follow->followed_user}}</div>
    <br>
@endforeach

@foreach ($tweets as $tweet)
    <div>{{$tweet->content}}</div>
    <br>
    <br>
@endforeach
<form action='/tweetFeed' method='get'>
    @csrf
    <button type='submit'> Feed</button>
</form>
@endguest

@endsection
