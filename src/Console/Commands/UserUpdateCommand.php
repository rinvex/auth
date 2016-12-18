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

namespace Rinvex\Fort\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Lang;
use Illuminate\Contracts\Validation\Factory;

class UserUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fort:user:update
                            {field? : The identifier of the user (id, email, username)}
                            {--E|email= : The Email of the user}
                            {--U|username= : The username of the user}
                            {--P|password= : The password of the user}
                            {--F|firstName= : The first name of the user}
                            {--M|middleName= : The middle name of the user}
                            {--L|lastName= : The last name of the user}
                            {--A|active : The active statuse of the user}
                            {--I|inactive : Set the user as inactive}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update an existing user.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $data = array_filter([

            // Required user attributes
            'email'       => $this->option('email'),
            'username'    => $this->option('username'),
            'password'    => $this->option('password') ? bcrypt($this->option('password')) : null,
            'first_name'  => $this->option('firstName'),
            'middle_name' => $this->option('middleName'),
            'last_name'   => $this->option('lastName'),
            'active'      => $this->option('active') ?: ! $this->option('inactive'),

        ], [
            $this,
            'filter',
        ]);

        // Get required argument
        $field = $this->argument('field') ?: $this->ask(Lang::get('rinvex.fort::artisan.user.invalid'));

        // Find single user
        if (intval($field)) {
            $user = $this->laravel['rinvex.fort.user']->find($field);
        } elseif (filter_var($field, FILTER_VALIDATE_EMAIL)) {
            $user = $this->laravel['rinvex.fort.user']->findWhere(['email' => $field])->first();
        } else {
            $user = $this->laravel['rinvex.fort.user']->findWhere(['username' => $field])->first();
        }

        if (! $user) {
            return $this->error(Lang::get('rinvex.fort::artisan.user.invalid', ['field' => $field]));
        }

        $rules = [
            'email'    => 'sometimes|required|email|max:255|unique:'.config('rinvex.fort.tables.users').',email',
            'username' => 'sometimes|required|max:255|unique:'.config('rinvex.fort.tables.users').',username',
        ];

        if (! empty($data)) {
            $validator = app(Factory::class)->make($data, $rules);

            if ($validator->fails()) {
                $this->error('Errors:');

                foreach ($validator->errors()->getMessages() as $key => $messages) {
                    $this->error('- '.$key.': '.$messages[0]);
                }
            } else {
                $user->update($data);

                $this->info(Lang::get('rinvex.fort::artisan.user.updated').' ['.Lang::get('rinvex.fort::artisan.user.id').': '.$user->id.', '.Lang::get('rinvex.fort::artisan.user.email').': '.$user->email.', '.Lang::get('rinvex.fort::artisan.user.username').': '.$user->username.']');
            }
        } else {
            $this->info(Lang::get('rinvex.fort::artisan.user.nothing'));
        }
    }

    /**
     * Filter null and empty values.
     *
     * @param $value
     *
     * @return bool
     */
    protected function filter($value)
    {
        return $value !== null && $value !== '';
    }
}
