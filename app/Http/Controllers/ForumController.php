<?php

namespace App\Http\Controllers;
use App\Topic;
use App\Message;

use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index()
    {
        $topics = Topic::orderBy('updated_at', 'desc')->paginate(15);
        return view('forum.index', [
            'topics' => $topics,
        ]);
    }

    public function view($id)
    {
        $topic = Topic::with('user')->findOrFail($id);
        return view('forum.view', [
            'topic' => $topic
        ]);
    }

    public function store(Request $request)
    {
        $topic = new Topic();
        $topic->fill($request->all());
        $topic->user_id = \Auth::user()->id;
        $topic->save();
    }
}
