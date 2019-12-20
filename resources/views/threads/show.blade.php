@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center">
    <div class="col-7">
            <div class="card">
                <div class="card-header"><h1>{{$item->title}}</h1></div>
                <div class="panel-body p-3">
                    <h4>{{$item->body}}</h4>
            </div>
        </div>
        <br>
        <h5>Replies: </h5>
        <br>
            <?php 
                $replies=$item->replies()->latest()->paginate(5)
            
            ?>
            @foreach ($replies as $reply)
                    @include('threads.reply')
            @endforeach
        {{-- Adding reply form --}}

            <div class="card mt-5">
                @if(auth()->check())
                    <form class='p-4' action="/threads/{{$item->channel->slug}}/{{$item->id}}/replies" method='post'>
                        @csrf
                        <div class="form-group">
                          <textarea placeholder='Type a reply...' class="form-control" name="body" id="add" rows="3"></textarea>
                        </div>
                        @error('body')
                            <span style='color: #d63031'>{{$message}}</span><br>
                        @enderror
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    @else
                    <p>
                        Please <a href="{{route('login')}}">sing in </a> to take participate in this discussion
                    </p>
                    @endif
            </div> 
    </div>

    {{-- ////// --}}

    <div class="col-4">
        <div class="card">
            <div class="card-header"><h1>{{$item->title}}</h1></div>
            <div class="panel-body">
                <h4>{{$item->repliesCount()}}</h4>
        </div>
    </div>
</div>
<div class="pageLinks" style='bottom: 0'>
    {{$replies->links()}}
</div>
@endsection
