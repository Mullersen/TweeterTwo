
@php // $follows is all the rows in Follow where user_id matches the id of logged in user

function checkUser($userToCheck, $follows){
    //we have to pass in the variable $follows above, becuase in a function you dont have access to variables from outside the varibale, unless you pass it in specifically.
    foreach ($follows as $checkedUser) {
        if($checkedUser->followed_user == $userToCheck){
            return true;
        }
    }
    return false;
}
//$likes are all the rows in Likes where user_id matches Auth::user()->id.
function checkTweet($tweetToCheck, $likes){
    foreach($likes as $checkedTweet){
        if($checkedTweet->tweet_id == $tweetToCheck){
            return false;
        }
    } return true;
}
echo($tweets);
@endphp

@foreach ($tweets as $tweet)
<div class="card mb-2">
    <div class="card-body">
        {{--Edit Tweet if owner--}}
        @if (Auth::user()->id == $tweet->user_id)
            <form class="float-right" action="/tweet/showTweet" method="get">
                <button class="btn btn-link btn-sm mb-2"  type="submit" name='id' value='tweetid'>Edit/Delete Tweet</button>
            </form>
        @endif
        {{--Show the tweet and author--}}
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
            <p class="card-text font-italic small mb-2">{{$tweet->created_at->diffForHumans()}}</p>
            <div class="row align-items-center">
                <div class="col-4 text-center">
                    <Like tweetid={{ $tweet->id }} likeCount={{App\Tweet::find($tweet->id)->like->count()}}></Like>
                </div>
                <div class="col-4 text-center">
                    @include('partials.followUnfollow')
                </div>
                @if ($tweet->is_retweet ==0)
                    <div class="col-4 text-center">
                        <Myretweet tweetid={{$tweet->id}} username={{ Auth::user()->name}} retweetcontent="{{$tweet->content}}" retweetauthor="{{App\Tweet::find($tweet->id)->user->name}}"/>
                    </div>
                @endif
            </div>
        @include('partials.tweetComment')
    </div>
</div>
@endforeach


