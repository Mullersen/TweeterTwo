<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;

class UserController extends Controller
{
    function search(){
        return view("search");
    }
    function searchUsername(Request $request){
        $searchedUser = \App\User::where(['name' => $request->username])->get();
        return response()->json(["users" => $searchedUser]);
    }

    function followUser(Request $request){
        //do I need to re-check if the logged in user is already following the user they are trying to follow? ( so it doesnt mess up my DB)
        $follow = new \App\Follow;
        $follow->user_id = Auth::user()->id;
        $follow->followed_user = $request->name;
        $follow->save();
        return redirect()->back();
    }

    function unfollowUser(Request $request){
            $authorName = $request->name;
            $matchThese = ['user_id'=> Auth::user()->id, 'followed_user'=> $authorName];
            \App\Follow::where($matchThese)->delete();
            return redirect()->back();
    }

    function showProfile($id){
        if (\App\User::find($id)){
            $tweets = \App\Tweet::where('user_id', $id)->get();
            $user = \App\User::find($id);
            $follows = \App\Follow::where('user_id', $id)->get();
            return view('profile', ['tweets' => $tweets, 'user' => $user, 'follows' => $follows]);
            } else {
                return view('error');
            }
    }

    function editEmail(Request $request){
            if(Auth::user()->id = $request->id){
                $data = $request->validate([
                    'email' => 'required|unique:users'
                ]);
                $id = $request->id;
                $user = \App\user::find($id);
                $user->email = $request->email;
                $user->save();
                return redirect('/profile/show/'. $id); // concatenates with the current id - replaces the curly braces in the route.
            } else {
                return view('error');
            }
    }

    function editPassword(Request $request){
            if(Auth::user()->id = $request->id){
                $id = $request->id;
                $user = \App\user::find($id);
                $request->validate([
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);
                $user->password = Hash::make($request->password);
                $user->save();
                return redirect('/profile/show/'. $id);
            } else {
                return view('error');
            }
    }

    function showDeleteQuestion(Request $request){
        if (Auth::user()->id == \App\User::find($request->id)->id){
            return view('deleteProfile');
        } else {
            return view ('error');
        }
    }

    function deleteProfile(Request $request){
        if (Auth::user()->id == \App\User::find($request->id)->id){
            $id = $request->id;
            \App\Like::where('user_id', $id)->delete();
            \App\Follow::where('user_id', $id)->delete();
            \App\Comment::where('user_id', $id)->delete();
            \App\Tweet::where('user_id', $id)->delete();
            \App\User::destroy($id);
            return redirect('/');
        } else {
            return view('error');
        }
    }
}

