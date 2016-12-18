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

use Illuminate\Http\Request;
use Rinvex\Fort\Contracts\UserRepositoryContract;
use Rinvex\Fort\Http\Controllers\AuthenticatedController;
use Rinvex\Fort\Http\Requests\Frontend\UserSettingsUpdateRequest;

class UserSettingsController extends AuthenticatedController
{
    /**
     * The user repository instance.
     *
     * @var \Rinvex\Fort\Contracts\UserRepositoryContract
     */
    protected $userRepository;

    /**
     * Create a new profile update controller instance.
     *
     * @param \Rinvex\Fort\Contracts\UserRepositoryContract $userRepository
     */
    public function __construct(UserRepositoryContract $userRepository)
    {
        parent::__construct();

        $this->userRepository = $userRepository;
    }

    /**
     * Show the account update form.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $countries = array_map(function ($country) {
            return $country->getName();
        }, countries());
        $twoFactor = $request->user($this->getGuard())->getTwoFactor();

        return view('rinvex/fort::frontend/user.settings', compact('twoFactor', 'countries'));
    }

    /**
     * Process the account update form.
     *
     * @param \Rinvex\Fort\Http\Requests\Frontend\UserSettingsUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(UserSettingsUpdateRequest $request)
    {
        $currentUser = $request->user($this->getGuard());
        $data = $request->except(['_token', 'id']);
        $twoFactor = $currentUser->getTwoFactor();

        $emailVerification = $data['email'] != $currentUser->email ? [
            'email_verified'    => false,
            'email_verified_at' => null,
        ] : [];

        $phoneVerification = $data['phone'] != $currentUser->phone ? [
            'phone_verified'    => false,
            'phone_verified_at' => null,
        ] : [];

        $countryVerification = $data['country'] !== $currentUser->country;

        if ($phoneVerification || $countryVerification) {
            array_set($twoFactor, 'phone.enabled', false);
        }

        $this->userRepository->update($request->get('id'), $data + $emailVerification + $phoneVerification + $twoFactor);

        return intend([
            'back' => true,
            'with' => [
                          'rinvex.fort.alert.success' => trans('rinvex/fort::frontend/messages.account.'.(! empty($emailVerification) ? 'reverify' : 'updated')),
                      ] + ($twoFactor !== $currentUser->getTwoFactor() ? ['rinvex.fort.alert.warning' => trans('rinvex/fort::frontend/messages.verification.twofactor.phone.auto_disabled')] : []),
        ]);
    }
}
