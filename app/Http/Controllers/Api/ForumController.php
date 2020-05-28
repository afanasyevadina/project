<?php

namespace App\Http\Controllers\Api;
use App\Message;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        if($request->file('file')) {
            $fileName = Storage::disk('public')
            ->putFileAs(
                'forum/'.$message->topic_id, $request->file('file'), 
                date('YmdHis').$request->file('file')->getClientOriginalName()
            );
            $message->file = '/storage/app/public/'.$fileName;
        }
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
        return response()->json($messages);
    }
}
