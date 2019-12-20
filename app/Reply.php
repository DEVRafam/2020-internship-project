<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Favorites;

class Reply extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function favorites()
    {
        return $this->morphMany(Favorites::class, 'favorited');
    }
    public function favorite()
    {
        if (!$this->favorites()->where(['user_id' => auth()->id()])->exists()) {
            return $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }
}
