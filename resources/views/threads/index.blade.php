@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class='pl-3'>
                <?php
                    if(request('by')) echo request('by');
                    else if(request('popularity')) echo 'Top 10 the most popular';
                    else echo 'All';
                    ?>
                Threads</h1>
            <hr>
            <button class="btn btn-primary"><a style='color:white' href="/threads/create">Create new Thread</a></button>
            <div class="card p-3 mt-2">
                <div class="panel-body p-3">
                    <?php
                        //Pagintation controller
                        $list=$threads;
                        // $linkAccess=true;
                        $linkAccess=false;
                    ?>
                    @foreach($threads as $item)
                        <article class='rm-post'>
                            <div class="rm-art-names">
                                <h4>{{$item->creator->name}}</h4>
                                <div class='text-right'>
                                    <h5>{{$item->created_at->diffForHumans()}}</h5>
                                    <h5>{{$item->repliesCount()}} comnments</h5>

                                </div>
                            </div>
                            <a href="{{$item->path()}}"><h4>{{$item->title}}</h4></a>
                            <div class="body">{{$item->body}}</div>
                        </article>
                        <br>
                        <hr>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
    @if((!request('by')) && (!request('popularity')))
        <div class="pageLinks">
            {{$list->links()}}
        </div>
    @endif;
@endsection
