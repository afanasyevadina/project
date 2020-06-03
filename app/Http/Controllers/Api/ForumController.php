<?php

namespace App\Http\Controllers\Api;
use App\Message;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ForumController extends Controller
{
    public function show($id)
    {
        $skip = \Request::get('skip') ?? 0;
        $messages = Message::with('user')->with('reply')
        ->where('topic_id', $id)
        ->latest('created_at')
        ->skip($skip)->take(20)->get();
        foreach($messages as $message) {
            if($message->for_owner == \Auth::user()->id) $message->for_owner = null;
            if($message->for_reply == \Auth::user()->id) $message->for_reply = null;
            $message->save();
        }
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
        $userid = $request->user()->id;
        $message->user_id = $userid;
        if($request->file('file')) {
            $fileName = Storage::disk('public')
            ->putFileAs(
                'forum/'.$message->topic_id, $request->file('file'), 
                date('YmdHis').$request->file('file')->getClientOriginalName()
            );
            $message->file = '/storage/app/public/'.$fileName;
        }
        if($message->topic->user_id != $userid) $message->for_owner = $message->topic->user_id;
        if($message->reply && $message->reply->user_id != $userid) $message->for_reply = $message->reply->user_id;
        $message->save();
        $reply = $message->reply;
        $user = $message->user;
        return $message;
    }

    public function refresh($id)
    {
        $since = \Request::get('since') ?? 0;
        $messages = Message::with('user')->with('reply')
        ->where('topic_id', $id)
        ->where('id', '>', $since)
        ->latest('created_at')->get();
        foreach($messages as $message) {
            if($message->for_owner == \Auth::user()->id) $message->for_owner = null;
            if($message->for_reply == \Auth::user()->id) $message->for_reply = null;
            $message->save();
        }
        return response()->json($messages);
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        if($message->user_id != $request->user()->id) {
            abort(403);
        }
        if($message->file && file_exists($message->file)) {
            unlink($message->file);
        }
        $message->delete();
    }
}
