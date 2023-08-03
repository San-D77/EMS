<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routes_to_check = config('constants.roles_to_check');
        $routeToFind = $request->route()->getName();

        if (in_array($routeToFind, $routes_to_check)) {
            $sidebarComponents = config('constants.sidebar_components');
            $found = null;
            foreach ($sidebarComponents as $component) {
                if ($component['hasChildren'] == 'true') {
                    foreach ($component['children'] as $child) {
                        if ($child['route'] == $routeToFind) {
                            if (in_array(Auth::user()->role->slug, $child['roles'])) {
                                $found = true;
                                break;
                            }
                        }
                    }
                } else {
                    if ($component['route'] == $routeToFind) {
                        if (in_array(Auth::user()->role->slug, $component['roles'])) {
                            $found = true;
                            break;
                        }
                    }
                }
            }
            if ($found) {
                return $next($request);
            } else {
                return redirect()->route('backend.unauthorized');
            }
        } else {
            return $next($request);
        }
    }
}
