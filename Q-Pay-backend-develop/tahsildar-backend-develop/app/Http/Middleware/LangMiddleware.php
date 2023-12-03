<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class LangMiddleware
{
    /**
     * Handle an incoming request for check lang of request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->header('lang');
        if ($lang == 'ar') {
            App::setLocale('ar');
            // set carbon locale en for get all date and time in english.
            Carbon::setLocale('en');
        } else {
            App::setLocale('en');
        }
        return $next($request);
    }
}
