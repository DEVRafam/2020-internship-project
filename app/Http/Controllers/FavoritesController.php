<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Favorites;

class FavoritesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Reply $reply)
    {
        return $reply->favorite();
        //to jest to samo
        /*Favorites::create([
            'user_id' => auth()->id(),
            'favorited_id' => $reply->id,
            'favorited_type' => get_class($reply)
        ]); */
    }
}
