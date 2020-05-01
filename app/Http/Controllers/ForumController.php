<?php

namespace App\Http\Controllers;
use App\Topic;
use App\Message;
use App\User;

use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        $topics = Topic::when($user->role != 'admin', function($q, $user) {
            return $q->whereHas('permissions', function($query) use($user) {
                $query->where('role', $user->role)->whereIn('user_id', [0, $user->id]);
            });
        })
        ->orderBy('updated_at', 'desc')->paginate(15);
        return view('forum.index', [
            'topics' => $topics,
        ]);
    }

    public function view($id)
    {
        $user = \Auth::user();
        $topic = Topic::with('user')->findOrFail($id);
        if(!$topic->allow()) abort(403);
        return view('forum.view', [
            'topic' => $topic
        ]);
    }

    public function edit($id)
    {
        $topic = Topic::with('user')->findOrFail($id);
        if($topic->user_id != \Auth::user()->id) abort(403);
        $roles = [
            'admin' => ['teacher', 'student'],
            'teacher' => ['teacher', 'student'],
            'student' => ['student'],
        ];
        $allowRoles = @$roles[\Auth::user()->role];
        $perm = $topic->permissions()->whereIn('role', $roles)->get()->mapToGroups(function ($item, $key) {
            return [$item['role'] => $item['user_id']];
        })->toArray();
        $users = User::whereIn('role', $roles)->get()->groupBy('role');
        return view('forum.edit', [
            'topic' => $topic,
            'perm' => $perm,
            'users' => $users,
            'roles' => [
                'teacher' => 'Преподаватели',
                'student' => 'Студенты',
            ],
        ]);
    }

    public function store(Request $request)
    {
        $topic = new Topic();
        $topic->fill($request->all());
        $topic->user_id = \Auth::user()->id;
        $topic->save();
        $topic->permissions()->create([
            'role' => \Auth::user()->role,
            'user_id' => \Auth::user()->id,
        ]);
    }

    public function update(Request $request, $id)
    {
        $topic = Topic::findOrFail($id);
        $topic->fill($request->all());
        $topic->save();
        foreach ($request->access as $role => $rule) {
            if($rule == 'all') {
                $topic->permissions()->where('role', $role)->delete();
                $topic->permissions()->updateOrCreate([
                    'role' => $role,
                    'user_id' => 0
                ]);
            } else {
                $users = isset($request->permission[$role]) ? $request->permission[$role] : [];
                foreach ($users as $userId) {
                    $topic->permissions()->updateOrCreate([
                        'role' => $role,
                        'user_id' => $userId
                    ]);
                }
                $topic->permissions()->where('role', $role)->whereNotIn('user_id', $users)->delete();
            }
        }
    }
}
