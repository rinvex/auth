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

use Rinvex\Fort\Models\Role;
use Rinvex\Fort\Models\User;
use Rinvex\Fort\Models\Ability;
use Rinvex\Fort\Models\Socialite;
use Rinvex\Fort\Models\Persistence;

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication and Authorization Models
    |--------------------------------------------------------------------------
    */

    'models' => [

        /*
        |--------------------------------------------------------------------------
        | Ability Model
        |--------------------------------------------------------------------------
        |
        | Specify your Eloquent model that should be used to retrieve your abilities.
        | Of course, it is often just the "Ability" model but you may use whatever
        | you like. The model you want to use as an ability model must extend
        | the `Rinvex\Fort\Models\Ability` base model.
        |
        | Default: Rinvex\Fort\Models\Ability::class
        |
        */

        'ability' => Ability::class,

        /*
        |--------------------------------------------------------------------------
        | Role Model
        |--------------------------------------------------------------------------
        |
        | Specify your Eloquent model that should be used to retrieve your roles.
        | Of course, it is often just the "Role" model but you may use whatever
        | you like. The model you want to use as a role model must extend
        | the `Rinvex\Fort\Models\Role` base model.
        |
        | Default: Rinvex\Fort\Models\Role::class
        |
        */

        'role' => Role::class,

        /*
        |--------------------------------------------------------------------------
        | User Model
        |--------------------------------------------------------------------------
        |
        | Specify your Eloquent model that should be used to retrieve your users.
        | Of course, it is often just the "User" model but you may use whatever
        | you like. The model you want to use as a user model must extend
        | the `Rinvex\Fort\Models\User` base model.
        |
        | Default: Rinvex\Fort\Models\User::class
        |
        */

        'user' => User::class,

        /*
        |--------------------------------------------------------------------------
        | Persistence Model
        |--------------------------------------------------------------------------
        |
        | Specify your Eloquent model that should be used to retrieve user persistences.
        | Of course, it is often just the "Persistence" model but you may use whatever
        | you like. The model you want to use as a persistence model must extend
        | the `Rinvex\Fort\Models\Persistence` base model.
        |
        | Default: Rinvex\Fort\Models\Persistence::class
        |
        */

        'persistence' => Persistence::class,

        /*
        |--------------------------------------------------------------------------
        | Socialite Model
        |--------------------------------------------------------------------------
        |
        | Specify your Eloquent model that should be used to retrieve user socialites.
        | Of course, it is often just the "Socialite" model but you may use whatever
        | you like. The model you want to use as a socialite model must extend
        | the `Rinvex\Fort\Models\Socialite` base model.
        |
        | Default: Rinvex\Fort\Models\Socialite::class
        |
        */

        'socialite' => Socialite::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication and Authorization Database Tables
    |--------------------------------------------------------------------------
    */

    'tables' => [

        /*
        |--------------------------------------------------------------------------
        | Abilities Table
        |--------------------------------------------------------------------------
        |
        | Specify your database table name that should be used to store
        | your abilities. You may use whatever you like.
        |
        | Default: "rinvex_fort_abilities"
        |
        */

        'abilities' => 'rinvex_fort_abilities',

        /*
        |--------------------------------------------------------------------------
        | Roles Table
        |--------------------------------------------------------------------------
        |
        | Specify database table name that should be used to store
        | your roles. You may use whatever you like.
        |
        | Default: "rinvex_fort_roles"
        |
        */

        'roles' => 'rinvex_fort_roles',

        /*
        |--------------------------------------------------------------------------
        | Users Table
        |--------------------------------------------------------------------------
        |
        | Specify database table name that should be used to store
        | your users. You may use whatever you like.
        |
        | Default: "rinvex_fort_users"
        |
        */

        'users' => 'rinvex_fort_users',

        /*
        |--------------------------------------------------------------------------
        | User Abilities Table
        |--------------------------------------------------------------------------
        |
        | Specify database table name that should be used to store the relation
        | between "users" and "abilities". You may use whatever you like.
        |
        | Default: "rinvex_fort_ability_user"
        |
        */

        'ability_user' => 'rinvex_fort_ability_user',

        /*
        |--------------------------------------------------------------------------
        | User Roles Table
        |--------------------------------------------------------------------------
        |
        | Specify database table name that should be used to store the relation
        | between "users" and "roles". You may use whatever you like.
        |
        | Default: "rinvex_fort_role_user"
        |
        */

        'role_user' => 'rinvex_fort_role_user',


        /*
        |--------------------------------------------------------------------------
        | Role Abilities Table
        |--------------------------------------------------------------------------
        |
        | Specify database table name that should be used to store the relation
        | between "roles" and "abilities". You may use  whatever you like.
        |
        | Default: "rinvex_fort_ability_role"
        |
        */

        'ability_role' => 'rinvex_fort_ability_role',

        /*
        |--------------------------------------------------------------------------
        | Verifications Table
        |--------------------------------------------------------------------------
        |
        | Specify database table name that should be used to store the
        | verification tokens. You may use whatever you like.
        |
        | Default: "rinvex_fort_verifications"
        |
        */

        'verifications' => 'rinvex_fort_verifications',

        /*
        |--------------------------------------------------------------------------
        | Reset Password Tokens Table
        |--------------------------------------------------------------------------
        |
        | Specify database table name that should be used to store the
        | reset password tokens. You may use whatever you like.
        |
        | Default: "rinvex_fort_resets"
        |
        */

        'resets' => 'rinvex_fort_resets',

        /*
        |--------------------------------------------------------------------------
        | Persistences Table
        |--------------------------------------------------------------------------
        |
        | Specify database table name that should be used to store the
        | user persistences. You may use whatever you like.
        |
        | Default: "rinvex_fort_persistences"
        |
        */

        'persistences' => 'rinvex_fort_persistences',

        /*
        |--------------------------------------------------------------------------
        | Socialite Table
        |--------------------------------------------------------------------------
        |
        | Specify database table name that should be used to store the
        | user social accounts. You may use whatever you like.
        |
        | Default: "rinvex_fort_socialite"
        |
        */

        'socialite' => 'rinvex_fort_socialite',

    ],

    /*
    |--------------------------------------------------------------------------
    | User Registration
    |--------------------------------------------------------------------------
    |
    */

    'registration' => [

        /*
        |--------------------------------------------------------------------------
        | User Registration
        |--------------------------------------------------------------------------
        |
        | This determines whether to allow user registration or not.
        |
        | Supported: true, false
        |
        | Default: true
        |
        */

        'enabled' => true,

        /*
        |--------------------------------------------------------------------------
        | User Registration Moderation
        |--------------------------------------------------------------------------
        |
        | This determines whether to moderate new user registrations or not.
        | When moderated, new registrations set as 'moderated' until admin approval.
        |
        | Supported: true, false
        |
        | Default: true
        |
        */

        'moderated' => false,

        /*
        |--------------------------------------------------------------------------
        | Default User Registration Role
        |--------------------------------------------------------------------------
        |
        | You may specify here default role to be assigned for newly registered users.
        |
        | Default: 'registered'
        |
        */

        'default_role' => 'registered',

    ],

    /*
    |--------------------------------------------------------------------------
    | Session Persistence
    |--------------------------------------------------------------------------
    |
    | This determines session persistence mode. Single persistence means
    | user can NOT login more than once in multiple browsers at the
    | same time. Recent login is the only kept active session.
    |
    | Supported: "single", "multiple"
    |
    | Default: "multiple"
    |
    */

    'persistence' => 'multiple',

    /*
    |--------------------------------------------------------------------------
    | Email Messaging
    |--------------------------------------------------------------------------
    */

    'email' => [

        /*
        |--------------------------------------------------------------------------
        | Send Welcome Email
        |--------------------------------------------------------------------------
        |
        | Send welcome email to users upon registration/verification success.
        |
        */

        'welcome' => true,

        /*
        |--------------------------------------------------------------------------
        | Send Verification Success Email
        |--------------------------------------------------------------------------
        |
        | Send verification success email to users upon completing email verification successfully.
        |
        */

        'verification' => true,

        /*
        |--------------------------------------------------------------------------
        | Send Lockout Email
        |--------------------------------------------------------------------------
        |
        | Send lockout email to users upon multiple failed login attempts.
        |
        */

        'lockout' => true,

    ],


    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Here you may set the options for resetting passwords including the view
    | that is your password reset e-mail. You may also set the name of the
    | table that maintains all of the reset tokens for your application.
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'reset' => [

        /*
        |--------------------------------------------------------------------------
        | Reset Password Default Broker
        |--------------------------------------------------------------------------
        |
        | This option controls the default reset password broker for your
        | application. You may change this default as required, but
        | they're a perfect start for most applications.
        |
        | Specify here reset password broker used to manage password resets.
        |
        | Supported: "users"
        |
        */

        'broker' => 'users',

        /*
        |--------------------------------------------------------------------------
        | Brokers Configuration
        |--------------------------------------------------------------------------
        |
        | Here you may configure brokers.
        | A default configuration has been added
        | for each back-end shipped with this package. You are free to add more.
        |
        */

        'users' => [
            'provider' => 'users',
            'email'    => 'rinvex.fort::password.message',
            'expire'   => 60,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Email Verification
    |--------------------------------------------------------------------------
    */

    'verification' => [

        /*
        |--------------------------------------------------------------------------
        | User Verification Requirement
        |--------------------------------------------------------------------------
        |
        | Here you may determine whether user verification required or not.
        |
        | Supported: true, false
        |
        | Default: true
        |
        */

        'required' => true,

        /*
        |--------------------------------------------------------------------------
        | Verification Default Broker
        |--------------------------------------------------------------------------
        |
        | This option controls the default verification broker for your
        | application. You may change this default as required, but
        | they're a perfect start for most applications.
        |
        | Specify here verification broker used to manage verifications.
        |
        | Supported: "users"
        |
        */

        'broker' => 'users',

        /*
        |--------------------------------------------------------------------------
        | Brokers Configuration
        |--------------------------------------------------------------------------
        |
        | Here you may configure brokers.
        | A default configuration has been added
        | for each back-end shipped with this package. You are free to add more.
        |
        */

        'users' => [
            'provider' => 'users',
            'email'    => 'rinvex.fort::verification.email.message',
            'expire'   => 60,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Login Throttling
    |--------------------------------------------------------------------------
    */

    'throttle' => [

        /*
        |--------------------------------------------------------------------------
        | Login Throttling Enabled
        |--------------------------------------------------------------------------
        |
        | Specify whether login throttling enabled or not.
        |
        | Default: true
        |
        */

        'enabled' => true,

        /*
        |--------------------------------------------------------------------------
        | Maximum Login Attempts
        |--------------------------------------------------------------------------
        |
        | Maximum number of login attempts for delaying further attempts.
        |
        | Default: 5
        |
        */

        'maxloginattempts' => 5,

        /*
        |--------------------------------------------------------------------------
        | Lockout Time
        |--------------------------------------------------------------------------
        |
        | Number of seconds to delay further login attempts.
        |
        | Default: 60
        |
        */

        'lockouttime' => 60,

    ],

    /*
    |--------------------------------------------------------------------------
    | Two-Factor authentication
    |--------------------------------------------------------------------------
    */

    'twofactor' => [

        /*
        |--------------------------------------------------------------------------
        | Two-Factor authentication issuer
        |--------------------------------------------------------------------------
        |
        | Every QR code generated for users enabling Two-Factor authentication via
        | the app must have issuer name, which is company's or project's name.
        |
        */

        'issuer' => 'Rinvex',

        /*
        |--------------------------------------------------------------------------
        | Default Two-Factor Providers
        |--------------------------------------------------------------------------
        |
        | The Rinvex Fort supports a variety of Two-Factor back-ends through unified
        | API, giving you convenient access to each back-end using the same syntax
        | for each one. Here you may set the active Two-Factor auth providers.
        |
        | Supported: "totp", "phone"
        |
        */

        'providers' => [

            'totp',
            'phone',

        ],

        /*
        |--------------------------------------------------------------------------
        | Two-Factor Providers
        |--------------------------------------------------------------------------
        |
        | Here you may configure as many Two-Factor "providers" as you wish, and you
        | may even configure multiple providers of the same provider. Defaults have
        | been setup for each provider as an example of the required options.
        |
        */

        'authy' => [

            'mode' => env('AUTHY_MODE', 'live'),

            'keys' => [
                'live'    => env('AUTHY_KEYS_LIVE', ''),
                'sandbox' => env('AUTHY_KEYS_SANDBOX', ''),
            ],

        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Social Authentication
    |--------------------------------------------------------------------------
    */

    'social' => [

        /*
        |--------------------------------------------------------------------------
        | Third Party Services
        |--------------------------------------------------------------------------
        |
        | This section is for storing the credentials for third party authentication
        | services such as Github, Facebook, Twitter, and others. This section
        | provides a sane default location for this type of information.
        |
        */

        'services' => [

            'facebook' => [
                'client_id'     => env('FACEBOOK_ID'),
                'client_secret' => env('FACEBOOK_SECRET'),
                'redirect'      => env('FACEBOOK_URL'),
            ],

            'google' => [
                'client_id'     => env('GOOGLE_ID'),
                'client_secret' => env('GOOGLE_SECRET'),
                'redirect'      => env('GOOGLE_URL'),
            ],

            'linkedin' => [
                'client_id'     => env('LINKEDIN_ID'),
                'client_secret' => env('LINKEDIN_SECRET'),
                'redirect'      => env('LINKEDIN_URL'),
            ],

            'twitter' => [
                'client_id'     => env('TWITTER_ID'),
                'client_secret' => env('TWITTER_SECRET'),
                'redirect'      => env('TWITTER_URL'),
            ],

            'github' => [
                'client_id'     => env('GITHUB_ID'),
                'client_secret' => env('GITHUB_SECRET'),
                'redirect'      => env('GITHUB_URL'),
            ],

            'bitbucket' => [
                'client_id'     => env('BITBUCKET_ID'),
                'client_secret' => env('BITBUCKET_SECRET'),
                'redirect'      => env('BITBUCKET_URL'),
            ],

        ],

    ],

];
