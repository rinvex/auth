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

return [

    'error' => '<strong>Whoops!</strong> There were some problems with your input.',

    'register' => [
        'success'        => 'Registration completed successfully!',
        'success_verify' => 'Registration completed successfully! Email verification request has been sent to you!',
        'disabled'       => 'Sorry, registration is currently disabled!',
    ],

    'account' => [
        'phone_required'   => 'You must verify your phone first!',
        'country_required' => 'You must select your country first!',
        'reverify'         => 'Since you updated your email, you must reverify your account again. You will not be able to login next time until you verify your account.',
        'updated'          => 'You have successfully updated your profile!',
    ],

    'auth' => [
        'unauthorized' => 'Sorry, you do not have access to this area!',
        'moderated'    => 'Your account is currently moderated!',
        'unverified'   => 'Your account in currently unverified!',
        'failed'       => 'These credentials do not match our records.',
        'lockout'      => 'Too many login attempts. Please try again in :seconds seconds.',
        'login'        => 'You have successfully logged in!',
        'valid'        => 'User credentials valid!',
        'logout'       => 'You have successfully logged out!',
        'already'      => 'You are already authenticated!',
        'session'      => [
            'required'   => 'You must login first!',
            'expired'    => 'Session expired, please login again!',
            'flushed'    => 'Your selected session has been successfully flushed!',
            'flushedall' => 'All your active sessions has been successfully flushed!',
        ],
    ],

    'passwordreset' => [
        'sent'             => 'Password reset request has been sent to you!',
        'success'          => 'Your password has been reset!',
        'invalid_password' => 'Passwords must be at least six characters and match the confirmation.',
        'invalid_token'    => 'This password reset token is invalid.',
        'invalid_user'     => 'We can not find a user with that e-mail address.',
    ],

    'verification' => [

        'email' => [
            'verified'      => 'Your email has been verified!',
            'link_sent'     => 'Email verification request has been sent to you!',
            'invalid_token' => 'This verification token is invalid.',
            'invalid_user'  => 'We can not find a user with that email address.',
        ],

        'phone' => [
            'verified' => 'Your phone has been verified!',
            'sent'     => 'We have sent your verification token to your phone!',
            'failed'   => 'Weird problem happen while verifying your phone, this issue has been logged and reported to staff.',
        ],

        'twofactor' => [
            'invalid_token' => 'This verification token is invalid.',
            'totp'          => [
                'required'         => 'Two-Factor TOTP authentication enabled for your account, authentication code required to proceed.',
                'enabled'          => 'Two-Factor TOTP authentication has been enabled and backup codes generated for your account.',
                'disabled'         => 'Two-Factor TOTP authentication has been disabled for your account.',
                'rebackup'         => 'Two-Factor TOTP authentication backup codes re-generated for your account.',
                'cant_backup'      => 'Two-Factor TOTP authentication currently disabled for your account, thus backup codes can not be generated.',
                'already'          => 'You have already configured Two-Factor TOTP authentication. This page allows you to switch to a different authentication app. If this is not what you\'d like to do, you can go back to your account settings.',
                'invalid_token'    => 'Your passcode did not match, or expired after scanning. Remove the old barcode from your app, and try again. Since this process is time-sensitive, make sure your device\'s date and time is set to "automatic."',
                'globaly_disabled' => 'Sorry, Two-Factor TOTP authentication globally disabled!',
            ],
            'phone'         => [
                'enabled'          => 'Two-Factor phone authentication has been enabled for your account.',
                'disabled'         => 'Two-Factor phone authentication has been disabled for your account.',
                'auto_disabled'    => 'Two-Factor phone authentication has been disabled for your account. Changing country or phone results in Two-Factor auto disable. You need to enable it again manually.',
                'country_required' => 'Country field seems to be missing in your account, and since Two-Factor authentication already activated which require that field, you can NOT login. Please contact staff to solve this issue.',
                'globaly_disabled' => 'Sorry, Two-Factor phone authentication globally disabled!',
            ],
        ],

    ],

];
