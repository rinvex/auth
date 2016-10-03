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

namespace Rinvex\Fort\Http\Controllers\Frontend;

use Rinvex\Fort\Contracts\UserRepositoryContract;
use Rinvex\Fort\Http\Controllers\AbstractController;
use Rinvex\Fort\Contracts\VerificationBrokerContract;
use Rinvex\Fort\Http\Requests\Frontend\UserRegistration;

class RegistrationController extends AbstractController
{
    /**
     * Create a new registration controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->getGuestMiddleware(), ['except' => $this->middlewareWhitelist]);
    }

    /**
     * Show the registration form.
     *
     * @param \Rinvex\Fort\Http\Requests\Frontend\UserRegistration $request
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegisteration(UserRegistration $request)
    {
        return view('rinvex.fort::frontend.authentication.register');
    }

    /**
     * Process the registration form.
     *
     * @param \Rinvex\Fort\Http\Requests\Frontend\UserRegistration $request
     * @param \Rinvex\Fort\Contracts\UserRepositoryContract        $userRepository
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function processRegisteration(UserRegistration $request, UserRepositoryContract $userRepository)
    {
        $result = $userRepository->create($request->except('_token'));

        switch ($result) {

            // Registration completed, verification required
            case VerificationBrokerContract::LINK_SENT:
                return intend([
                    'home' => true,
                    'with' => ['rinvex.fort.alert.success' => trans('rinvex.fort::frontend/messages.register.success_verify')],
                ]);

            // Registration completed successfully
            case UserRepositoryContract::AUTH_REGISTERED:
            default:
                return intend([
                    'intended' => route('rinvex.fort.frontend.auth.login'),
                    'with'     => ['rinvex.fort.alert.success' => trans($result)],
                ]);

        }
    }
}
