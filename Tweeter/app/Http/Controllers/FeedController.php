<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class FeedController extends Controller
{
    function showAll(){
        if (Auth::check()){
        $tweets = \App\Tweet::all();
        $follows = \App\Follow::where('user_id', Auth::user()->id)->get();
        return view('tweetFeed', ['tweets' => $tweets, 'follows' => $follows]);
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
         //check if the user that is logged in owns the tweet that you are trying to edit
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
            //check if the user that is logged in owns the tweet that you are trying to edit
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
            //ahthenticate user, and make sure the tweet the logged in user is owned by that user
            if (Auth::check()){
                if (Auth::user()->id == \App\Tweet::find($request->id)->user_id){
                    $id = $request->id;
                    $tweet = \App\Tweet::find($id);
                    return view('deleteTweet', ['tweet' => $tweet]);
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
                return redirect('/tweetFeed');
            } else {
                return view('error');
            }
        } else {
            return view('error');
        }
    }
}


/*
$id = $request->id;
function store(Request $request){
    $data = $request->validate([
        'author'=> 'max:50',
        'content'=> 'bail|required|min:5|max:500'
    ]);
    $tweet = new \App\Tweet; //we make a new object - which will be our new row.
    $tweet->author = $request->author; // we assign the values of the new object /the values of the new rows.
    $tweet->content = $request->content;
    $tweet->save(); // we save it in our database.
    return redirect('/profile');
}


function delete(Request $request){
    $id = $request->id;
    \App\Tweet::destroy($id);
    return redirect('/profile');
}

function edit(Request $request){
    $id = $request->id;
    $tweet =  \App\Tweet::find($id);
    return view('editTweet', ['tweet' => $tweet]);
}
function save(Request $request){
    $data = $request->validate([ //if the validation fails it sends the user back to the previous view(by GET method), with an error message. You can access that message through @error
        'author'=> 'max:50',
        'content'=> 'bail|required|min:5|max:500'
    ]);
    $id =$request->id;
    $tweet = \App\Tweet::find($id);
    $tweet->author = $request->author;
    $tweet->content = $request->content;
    $tweet->save();

    return redirect('/profile');
    //$result = \App\Tweet::all();
    //return view('profile', ['tweets' => $result]);
}

function showUsers(){
    if(Auth::check()){ // checking if the user is logged in, because the following page is protected, and can only show if logged in.
        $users = \App\User::all();
        $follows = \App\Follows::where('followingUser', Auth::user()->name)->get(); // we want to get all the rows where FollowingUser's name equals logged in users name.
        return view ('users', ['users' => $users, 'follows' => $follows]); // the array we pass to the view can hold multiple items.
    } else {
        return redirect('/home');
    }
}

function followUsers(Request $request){ //adds the followedUser and followingUser to the following table when the button is clicked on the users view.
    $follow = new \App\Follows;
    $follow->followingUser = Auth::user()->name;
    $follow->followedUser = $request->name;
    $follow->save();
    return redirect('/profile/users');
}
*/
