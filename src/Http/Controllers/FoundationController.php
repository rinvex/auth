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

namespace Rinvex\Fort\Http\Controllers;

use Illuminate\Routing\Controller;
use Rinvex\Fort\Traits\GetsMiddleware;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FoundationController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, GetsMiddleware;

    /**
     * The password broker.
     *
     * @var string
     */
    protected $broker;

    /**
     * Get the broker to be used.
     *
     * @return string
     */
    protected function getBroker()
    {
        return $this->broker;
    }
}
