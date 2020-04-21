<?php

namespace App\Http\Controllers\Api;
use App\Message;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForumController extends Controller
{
    public function view($id)
    {
        $skip = \Request::get('skip') ?? 0;
        $messages = Message::with('user')->with('reply')
        ->where('topic_id', $id)
        ->latest('created_at')
        ->skip($skip)->take(20)->get();
        return response()->json($messages);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = new Message();
        $message->fill($request->all());
        $message->user_id = $request->user()->id;
        $message->save();
        $reply = $message->reply;
        $user = $message->user;
        return $message;
    }
}
