{{--Follow/unfollow--}}
@if (Auth::user()->id !== $tweet->user_id)
    @if (checkUser(App\Tweet::find($tweet->id)->user->name, $follows)){{--check all the current followed authors against the current tweets author--}}
        <form action="/profile/unfollowUser" method="POST">
            @csrf
            <button class="btn btn-outline-primary btn-sm"  name='name' value='{{App\Tweet::find($tweet->id)->user->name}}'>Unfollow User</button>
        </form>
    @else
        <form action="/profile/followUser" method="POST"style="display:inline">
            @csrf
            <button class="btn btn-outline-primary btn-sm"  name='name' value='{{App\Tweet::find($tweet->id)->user->name}}'>Follow User</button>
        </form>
    @endif

@else
<button type="button" class="btn btn-outline-primary btn-sm mb-3" style="cursor:default" disabled>Follow</button>
@endif
