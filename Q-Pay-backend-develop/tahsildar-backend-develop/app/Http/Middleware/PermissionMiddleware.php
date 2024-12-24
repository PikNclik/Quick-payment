<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permissionCategory, $permission)
    {
        $user = Auth::user();
        if ($user->role->name == "Super Admin") {
            return $next($request);
        }
        
        if (!$user || !$user->role || count($user->role->permissions) == 0) {
            abort(403, 'Access denied');
        }
        $permissions = $user->role->permissions->toArray();
        $filteredArray = array_filter($permissions, function ($per) use ($permissionCategory, $permission) {
            return strtolower($per['category_name']) == strtolower($permissionCategory) && strtolower($per['name']) == strtolower($permission);
        });
        if (count($filteredArray) == 0)
            abort(403, 'Access denied');

        return $next($request);
    }
}
