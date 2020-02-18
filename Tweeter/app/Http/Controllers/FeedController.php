<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class FeedController extends Controller
{
    function showAll(){
        if (Auth::check()){
        $tweets = \App\Tweet::all()->sortBy('created_at')->reverse();
        $follows = \App\Follow::where('user_id', Auth::user()->id)->get();
        $comments = \App\Comment::all();
        $likes = \App\Like::where('user_id', Auth::user()->id)->get();
        return view('tweetFeed', ['tweets' => $tweets, 'follows' => $follows, 'comments' => $comments, 'likes' => $likes]);
        } else {
        $tweets = \App\Tweet::all();
        return view('tweetFeed', ['tweets' => $tweets]);
        }
    }
    function newTweet(Request $request){
        if (Auth::check()){
        $data = $request->validate([
            'content' => 'required|min:5|max:500'
        ]);
        $tweet = new \App\Tweet;
        $tweet->user_id = Auth::user()->id;
        $tweet->content = $request->content;
        $tweet->save();
        return redirect('/tweetFeed');
            } else {
                return view('error');
            }
    }

    function showTweet(Request $request){
        if (Auth::check()){
            if(Auth::user()->id == \App\Tweet::find($request->id)->user_id){
            $id = $request->id;
            $tweet = \App\Tweet::find($id);
            return view('tweet', ['tweet' => $tweet]);
            } else {
                return view('error');
            }
        } else {
            return view('error');
        }
    }
    function editTweet(Request $request){
            if (Auth::check()){
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
        } else {
            return view('error');
        }
    }

    function showDeleteQuestion(Request $request){
            if (Auth::check()){
                if (Auth::user()->id == \App\Tweet::find($request->id)->user_id){
                    $id = $request->id;
                    $tweet = \App\Tweet::find($id);
                    $comments = \App\Comment::all();
                    return view('deleteTweet', ['tweet' => $tweet, 'comments' => $comments]);
                } else {
                    return view('error');
                }
        } else {
            return view('error');
        }
    }

    function deleteTweet(Request $request){
        if (Auth::check()){
            if (Auth::user()->id == \App\Tweet::find($request->id)->user_id){
                $id = $request->id;
                \App\Tweet::destroy($id);
                \App\Comment::where('tweet_id', $id)->delete();
                return redirect('/tweetFeed');
            } else {
                return view('error');
            }
        } else {
            return view('error');
        }
    }

    function newComment(Request $request){
        if (Auth::check()){
            $comment = new \App\Comment;
            $comment->user_id = Auth::user()->id;
            $comment->tweet_id = $request->id;
            $comment->content = $request->content;
            $comment->save();
            return redirect('/tweetFeed');
        } else{
            return view('error');
        }
    }
    function deleteComment(Request $request){
        if (Auth::check()){
            $id = $request->id;
            if(Auth::user()->id == \App\Comment::find($id)->user_id){
                \App\Comment::destroy($id);
                return redirect('/tweetFeed');
            } else {
                return view('error');
            }
        } else {
            return view('error');
        }
    }
    function showComment(Request $request){
        if (Auth::check()){
            $id = $request->id;
            if(Auth::user()->id == \App\Comment::find($id)->user_id){
               $comment = \App\Comment::find($id);
               $tweet = \App\Comment::find($id)->tweet;
                return view('comment', ['comment' => $comment, 'tweet' => $tweet]);
            }
        }
    }
    function editComment(Request $request){
        if (Auth::check()){
            $id =$request->id;
            if(Auth::user()->id == \App\Comment::find($id)->user_id){
                $comment = \App\Comment::find($id);
                $comment->content = $request->content;
                $comment->save();
                return redirect('/tweetFeed');
            } else {
                return view('error');
            }
        } else {
        return view('error');
        }
    }
    function likeTweet(Request $request){
        if (Auth::check()){
            //insert check if the person has already liked the tweet
            $like = new \App\Like;
            $like->user_id = Auth::user()->id;
            $like->tweet_id = $request->id;
            $like->save();
            return redirect('/tweetFeed');
        } else {
            return view('error');
        }
    }
    function unlikeTweet(Request $request){
        if (Auth::check()){
            $matchThese = ['user_id'=> Auth::user()->id, 'tweet_id'=> $request->id];
            \App\Like::where($matchThese)->delete();
            return redirect('/tweetFeed');
        } else {
            return view ('error');
        }
    }
}

