<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadsFilter
{
    /**
     * @var Request
     */
    public function __construct(Request $request)
    {
        $this->requset = $request;
    }
    public function apply($builder)
    {
        dd('a');
        if (!$username = request('by')) return $builder;

        $id = User::where('name', $username)->firstOrFail()->id;
        return $builder->where('user_id', $id);
    }
}
