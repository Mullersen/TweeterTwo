<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Log;


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
        $receivedMessages = \App\Message::where($matchThese)->get();

        //error_log($request);

        $matchTheseToo = ['sender'=> Auth::user()->name, 'receiver'=> $request->user];
        $sentMessages = \App\Message::where($matchTheseToo)->get();

        $messages = $receivedMessages->concat($sentMessages);
        $sorted = $messages->sortBy('created_at');
        return response()->json(['messages' => $sorted, 'myUser' => Auth::user()->name]);
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
