<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class MessageController extends Controller
{
    function showMessages(){
        return view('messages');
    }

    function getFollows(){
        return response()->json(['follows' => \App\Follow::where('user_id', Auth::user()->id)->get()]);
    }

    function getMessages(Request $request){
        $matchThese = ['sender'=> $request->user, 'receiver'=> Auth::user()->name];
        //$matchTheseToo = ['sender'=> Auth::user()->name, 'receiver'=> $request->user];
        $messages = \App\Message::where($matchThese)
                                ->get();

        // $messages = \App\Message::where(['sender'=> $request->user, 'receiver'=> Auth::user()->name])
        //                                     ->orWhere(['sender'=> Auth::user()->name, 'receiver'=> $request->user])
        //                                     ->get();
        return response()->json(['messages' => $messages, 'myUser' => Auth::user()->name]);
    }

    function sendMessage(Request $request){
        $message = new \App\Message;
        $message->sender = Auth::user()->name;
        $message->receiver = $request->receiver;
        $message->message = $request->content;
        $message->save();
        return response()->json(['status' => 'message uploaded to DB']);
    }
}
