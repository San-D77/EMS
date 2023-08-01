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

        $sidebarComponents = config('constants.sidebar_components');
        $routeToFind = $request->route()->getName();
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
    }
}
