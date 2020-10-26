<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->admin == 0){
            $thisPost = Post::find($request->route('id'));
            if($request->user()->id !== $thisPost['user_id']){
                $errorMessage = "You are not allowed to view that page.";
                return redirect('')->withErrors([$errorMessage]);
            }

        }

        return $next($request);
    }
}
