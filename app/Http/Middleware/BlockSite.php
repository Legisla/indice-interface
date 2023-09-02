<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlockSite
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(config('block.site.active') && !session('shouldUnlock') ){
            return new Response(view('blocked'));
        }

        return $next($request);
    }
}
