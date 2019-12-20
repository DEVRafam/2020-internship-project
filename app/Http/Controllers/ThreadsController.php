<?php

namespace App\Http\Controllers;

//use App\Fil\ThreadsFilter;
//use App\Filters\ThreadsFilter;
use App\Thread;
use App\User;
use App\Channel;
use Illuminate\Http\Request;
use Illuminate\Queue\Console\RetryCommand;

class ThreadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Channel $channel)
    {
        $threads = $this->getThreads($channel);
        if (request()->wantsJson()) {
            return $threads;
        }
        return view('threads.index', compact('threads'));
    }
    protected function getThreads(Channel $channel)
    {
        if ($channel->exists) {
            $threads = Thread::where('channel_id', $channel->id)->latest()->paginate(10);
        } else  $threads = Thread::latest()->paginate(10);


        if ($username = request('by')) {
            $id = User::where('name', $username)->firstOrFail()->id;
            $threads = Thread::where('user_id', $id)->latest()->get();
        }

        if (request('popularity')) {
            $threads = Thread::all()->sortByDesc('replies_count')->take(10);
        }
        return $threads;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create', ['tempChannel' => Channel::all()->first()->id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required|min:3',
            'body' => 'required|min:8',
            'channel_id' => 'required|exists:channels,id'
        ]);
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'title' => request('title'),
            'body' => request('body'),
            'channel_id' => request('channel_id')
        ]);
        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channel, Thread $thread)
    {
        //
        // $item = Thread::findOrFail($id);
        return view('threads.show', ['item' => $thread]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
    public function myThreads()
    {
        $threads = Thread::all()->where('user_id', auth()->id());
        return view('threads.index', compact('threads'));
    }
}
