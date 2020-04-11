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
        $messagesReceived = \App\Message::where(['sender'=> $request->user, 'receiver'=> Auth::user()->name])->get();
        $messagesSent = \App\Message::where(['sender'=> Auth::user()->name, 'receiver'=> $request->user])->get();
        return response()->json(['receivedMessages' => $messagesReceived], ['sentMessages' => $messagesSent]);
    }
}
