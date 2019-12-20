<div class="card mt-4">
    <div class="card-header d-flex rm-wrap">
        <a href="#">{{$reply->owner->name}}</a>
        <p>{{$reply->created_at->diffForHumans()}}</p>
    </div>
    
    <div class="panel-body p-3">
        {{$reply->body}}
    </div>
</div>