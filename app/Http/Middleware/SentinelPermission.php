<?php

namespace Fully\Http\Middleware;

use Closure;
use Sentinel;
use Redirect;
use Flash;

class SentinelPermission {

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Sentinel::check()) {
            if (!Sentinel::inRole('superadmin')) {
                if (!$request->route()->getName()) {
                    return $next($request);
                }
                $routeName = $request->route()->getName();
                $routeName = str_replace(getLang() . '.', '', $routeName);
                
                if ($routeName != 'admin.dashboard' && !Sentinel::hasAccess($routeName)) {
                    Flash::error('Bạn không có quyền vào mục này');

                    return Redirect::route('admin.dashboard')->withErrors('Permission denied.');
                }
            }
        }

        return $next($request);
    }

}
