{{--Show only the comments that belongs to the tweet--}}
@foreach ($comments as $comment)
    @if ($comment->tweet_id == $tweet->id)
        <div class="container">
            <p class="card-text small mb-1 font-weight-bold">{{\App\Comment::find($comment->id)->user->name}}</p>
            <p class="card-text small mb-2 border-bottom">- {{$comment->content}}</p>
        {{--Edit comment if it belongs to the logged in user--}}
            @if ($comment->user_id == Auth::user()->id)
                <form action="/comment/deleteComment" method="POST" style="display:inline">
                    @csrf
                    <button class="btn btn-link btn-sm"  name='id' value='{{$comment->id}}'>Delete Comment</button>
                </form>
                <form action="/comment/showComment" method="POST" style="display:inline">
                    @csrf
                    <button class="btn btn-link btn-sm"  name='id' value='{{$comment->id}}'>Edit Comment</button>
                </form>
            @endif
        </div>
    @endif
@endforeach
{{--Show only the gifs that belongs to the tweet--}}
@foreach ($gifs as $gif)
    @if ($gif->tweet_id == $tweet->id)
        <div class="container mb-2">
            <p class="card-text small mb-1 font-weight-bold">{{\App\GIF::find($gif->id)->user->name}}</p>
            <div class="col-sm-6">
                <img class="card-img border-bottom" src="{{$gif->URL}}" alt="commented Gif">
            </div>
                {{--Delete gif comment if it belongs to the logged in user--}}
                @if ($gif->user_id == Auth::user()->id)
                    <form action="/comment/deleteGifComment" method="POST" style="display:inline">
                        @csrf
                        <button class="btn btn-link btn-sm"  name='id' value='{{$gif->id}}'>Delete GIF</button>
                    </form>
                @endif
        </div>
    @endif
@endforeach
{{--add comment to tweet--}}
<div>
<Giphy :tweetid="{{ $tweet->id }}" username="{{ Auth::user()->name }}"/>
</div>
<form class="form-inline mt-1" action="/comment/addComment" method="POST">
    @csrf
    <input type='hidden' name='user' value='{{Auth::user()->name}}'>
    <div class="form-group mb-0">
        <textarea class="form-control form-control-sm rounded-pill" style="width: 100%" rows="1" name='content'></textarea>
    </div>
    <button class="btn btn-primary btn-sm ml-2 rounded-pill"  name='id' value='{{$tweet->id}}'>Comment</button>
</form>

