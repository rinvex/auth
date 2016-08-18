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

namespace Rinvex\Fort\Contracts;

use Rinvex\Repository\Contracts\CacheableContract;
use Rinvex\Repository\Contracts\RepositoryContract;

interface UserRepositoryContract extends RepositoryContract, CacheableContract
{
    /**
     * Find a user by its email.
     *
     * @param string $email
     *
     * @return \Rinvex\Fort\Contracts\AuthenticatableContract|null
     */
    public function findByEmail($email);

    /**
     * Find a user by its username.
     *
     * @param string $username
     *
     * @return \Rinvex\Fort\Contracts\AuthenticatableContract|null
     */
    public function findByUsername($username);

    /**
     * Find a user by their unique identifier and "remember me" token.
     *
     * @param mixed  $identifier
     * @param string $token
     *
     * @return \Rinvex\Fort\Contracts\AuthenticatableContract|null
     */
    public function findByToken($identifier, $token);

    /**
     * Find a user by the given credentials.
     *
     * @param array $credentials
     *
     * @return \Rinvex\Fort\Contracts\AuthenticatableContract|null
     */
    public function findByCredentials(array $credentials);

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param \Rinvex\Fort\Contracts\AuthenticatableContract $user
     * @param string                                         $token
     *
     * @return void
     */
    public function updateRememberToken(AuthenticatableContract $user, $token);

    /**
     * Validate a user against the given credentials.
     *
     * @param \Rinvex\Fort\Contracts\AuthenticatableContract $user
     * @param array                                          $credentials
     *
     * @return bool
     */
    public function validateCredentials(AuthenticatableContract $user, array $credentials);
}
