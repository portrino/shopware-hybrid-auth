<?php
namespace Port1HybridAuth\Service;

use Port1HybridAuth\Model\User;

/**
 * Interface AuthenticationServiceInterface
 *
 * @package Port1HybridAuth\Service
 */
interface AuthenticationServiceInterface
{
    /**
     * @return boolean true if the user is authenticated
     */
    public function login();

    /**
     * @return User|null
     */
    public function getUser();

    /**
     * @return boolean true if the user is authenticated
     */
    public function isAuthenticated();

    /**
     * @return boolean true if the user was successfully logged out
     */
    public function logout();
}
