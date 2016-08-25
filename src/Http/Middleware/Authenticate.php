<?php

/*
 * NOTICE OF LICENSE
 *
 * Part of the Rinvex Fort Package.
 *
 * This source file is subject to The MIT License (MIT)
 * that is bundled with this package in the LICENSE file.
 *
 * Package: Rinvex Fort Package
 * License: The MIT License (MIT)
 * Link:    https://rinvex.com
 */

namespace Rinvex\Fort\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guest = Auth::guard($guard)->guest()) {
            return intend([
                'intended'   => route('rinvex.fort.auth.login'),
                'withErrors' => ['rinvex.fort.session.expired' => Lang::get('rinvex.fort::message.auth.session.'.($guest ? 'expired' : 'required'))],
            ], 401);
        }

        return $next($request);
    }
}
