<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class FeedController extends Controller
{
    function showAll(){
        if (Auth::check()){
            $follows = \App\Follow::where('user_id', Auth::user()->id)->get();
            $followCount = $follows->count();
            if ($followCount == 0){
                return redirect('/discoveryFeed');
            } else {
                $tweets = \App\Tweet::all()->sortBy('created_at')->reverse();
                $comments = \App\Comment::all();
                $gifs = \App\GIF::all();
                $likes = \App\Like::where('user_id', Auth::user()->id)->get();
                return view('tweetFeed', ['tweets' => $tweets, 'follows' => $follows, 'comments' => $comments, 'likes' => $likes, 'gifs' => $gifs]);
                }
        } else {
            $tweets = \App\Tweet::all();
            return view('tweetFeed', ['tweets' => $tweets]);
            }
    }

    function getMyLikes(){
        return response()->json([
        'myLikes' => \App\Like::where('user_id', Auth::user()->id)->get()
        ]);
    }

    function newTweet(Request $request){
        $data = $request->validate([
            'content' => 'required|min:5|max:500'
        ]);
        $tweet = new \App\Tweet;
        $tweet->user_id = Auth::user()->id;
        $tweet->content = $request->content;
        $tweet->save();
        return redirect('/tweetFeed');
    }

    function showTweet(Request $request){
            if(Auth::user()->id == \App\Tweet::find($request->id)->user_id){
            $id = $request->id;
            $tweet = \App\Tweet::find($id);
            return view('tweet', ['tweet' => $tweet]);
            } else {
                return view('error');
            }
    }

    function editTweet(Request $request){
                if(Auth::user()->id == \App\Tweet::find($request->id)->user_id){
                $data = $request->validate([
                    'content' => 'required|min:5|max:500'
                ]);
                $id =$request->id;
                $tweet = \App\Tweet::find($id);
                $tweet->user_id = Auth::user()->id;
                $tweet->content = $request->content;
                $tweet->save();
                return redirect('/tweetFeed');
            } else{
                return view('error');
            }
    }

    function showDeleteQuestion(Request $request){
                if (Auth::user()->id == \App\Tweet::find($request->id)->user_id){
                    $id = $request->id;
                    $tweet = \App\Tweet::find($id);
                    $comments = \App\Comment::all();
                    return view('deleteTweet', ['tweet' => $tweet, 'comments' => $comments]);
                } else {
                    return view('error');
                }
    }

    function deleteTweet(Request $request){
            if (Auth::user()->id == \App\Tweet::find($request->id)->user_id){
                $id = $request->id;
                \App\Tweet::destroy($id);
                \App\Comment::where('tweet_id', $id)->delete();
                return redirect('/tweetFeed');
            } else {
                return view('error');
            }
    }

    function newComment(Request $request){
            $comment = new \App\Comment;
            $comment->user_id = Auth::user()->id;
            $comment->tweet_id = $request->id;
            $comment->content = $request->content;
            $comment->save();
            return redirect('/tweetFeed');
    }

    function newGifComment(Request $request){
        $GIF = new \App\GIF;
        $GIF->user_id = Auth::user()->id;
        $GIF->tweet_id = $request->id;
        $GIF->URL = $request->URL;
        $GIF->save();
        return response()->json(["URL" => $request->URL, "gifs_tweet_id" => $request->id, "gifs_id" => $GIF->id]);
    }

    function deleteComment(Request $request){
            $id = $request->id;
            if(Auth::user()->id == \App\Comment::find($id)->user_id){
                \App\Comment::destroy($id);
                return redirect('/tweetFeed');
            } else {
                return view('error');
            }
    }

    function deleteGifComment(Request $request){
            $id = $request->id;
            if(Auth::user()->id == \App\GIF::find($id)->user_id){
                \App\GIF::destroy($id);
                return redirect('/tweetFeed');
            } else {
                return view('error');
            }
    }

    function showComment(Request $request){
            $id = $request->id;
            if(Auth::user()->id == \App\Comment::find($id)->user_id){
               $comment = \App\Comment::find($id);
               $tweet = \App\Comment::find($id)->tweet;
                return view('comment', ['comment' => $comment, 'tweet' => $tweet]);
            } else {
                return view('error');
            }
    }

    function editComment(Request $request){
            $id =$request->id;
            if(Auth::user()->id == \App\Comment::find($id)->user_id){
                $comment = \App\Comment::find($id);
                $comment->content = $request->content;
                $comment->save();
                return redirect('/tweetFeed');
            } else {
                return view('error');
            }
    }
    function likeTweet(Request $request){
            //insert check if the person has already liked the tweet
            $like = new \App\Like;
            $like->user_id = Auth::user()->id;
            $like->tweet_id = $request->key;
            $like->save();
            return response()->json(['status' => 'deleted']);
    }

    function unlikeTweet(Request $request){
            $matchThese = ['user_id'=> Auth::user()->id, 'tweet_id'=> $request->key];
            \App\Like::where($matchThese)->delete();
            return response()->json(['status' => 'success']);
    }

    function discover(){
        $tweets = \App\Tweet::all()->sortBy('created_at')->reverse();
        $follows = \App\Follow::where('user_id', Auth::user()->id)->get();
        $comments = \App\Comment::all();
        $likes = \App\Like::where('user_id', Auth::user()->id)->get();
        return view('discoveryFeed', ['tweets' => $tweets, 'follows' => $follows, 'comments' => $comments, 'likes' => $likes]);
    }
}

