<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });
    }

    public function path()
    {
        // return '/threads/' . $this->id;
        return "/threads/{$this->channel->slug}/{$this->id}";
    }


    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function repliesCount()
    {
        return $this->replies()->count();
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    public function addReply($reply)
    {
        return $this->replies()->create($reply);
    }


    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
    /*
    public function scopeFilter($query, $filter)
    {
        return $this->$filter->apply($query);
    }
    */
}
