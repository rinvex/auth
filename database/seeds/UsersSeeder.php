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

namespace Rinvex\Fort\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table(config('rinvex.fort.tables.users'))->truncate();

        // Get users data
        $users = json_decode(file_get_contents(__DIR__.'/../../resources/data/users.json'), true);

        // Create new users
        foreach ($users as $user) {
            $user['password'] = str_random();
            app('rinvex.fort.user')->create($user);

            if (isset($this->command)) {
                $this->command->getOutput()->writeln("<comment>Username</comment>: {$user['username']} / <comment>Password</comment>: {$user['password']}");
            }
        }

        // Assign roles to users
        app('rinvex.fort.user')->findBy('email', 'help@rinvex.com')->assignRoles('admin');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}