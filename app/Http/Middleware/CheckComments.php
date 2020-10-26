<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckComments
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
        $commentsCount = count(Auth::user()->comments()->get());

        if($commentsCount < 1){
            $errorMessage = "You need to comment at least once before you can upload.";
            return redirect('')->withErrors([$errorMessage]);
        }

        return $next($request);
    }
}
