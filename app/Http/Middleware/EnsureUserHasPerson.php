<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasPerson
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            // Exclude super admin (user_level_id == 1)
            if ((int) $user->user_level_id === 1) {
                return $next($request);
            }

            // Avoid redirect loops: allow certain route names & paths
            $allowedRouteNames = [
                'profile.edit',
                'person.store',
                'person.update',
                'logout',
            ];

            $currentRouteName = optional($request->route())->getName();

            $isAllowed = in_array($currentRouteName, $allowedRouteNames, true)
                || $request->is('logout')
                || $request->is('profile')
                || $request->is('profile/*')
                || $request->is('password/*');

            if (! $isAllowed && ! $user->people()->exists()) {
                return redirect()
                    ->route('profile.edit')
                    ->with('status', 'Completa tu información personal antes de continuar.')
                    ->with('person_required', true);
            }
        }

        return $next($request);
    }
}
