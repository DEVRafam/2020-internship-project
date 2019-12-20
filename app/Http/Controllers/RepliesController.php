<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Thread;

class RepliesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channel = null, Thread $thread)
    {
        request()->validate([
            'body' => 'required'
        ]);
        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);
        return back();
    }
}
