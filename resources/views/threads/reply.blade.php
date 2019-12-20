<div class="card mt-4">
    <div class="card-header d-flex rm-wrap">
        <div>
            <a href="#">{{$reply->owner->name}}</a>
            <i class="fa fa-heart"></i>
            Like it
        </div>
        <span>{{$reply->created_at->diffForHumans()}}</span>
    </div>
    
    <div class="panel-body p-3">
    </div>
</div>