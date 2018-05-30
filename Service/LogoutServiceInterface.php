<?php
namespace Port1HybridAuth\Service;

/**
 * Interface LogoutServiceInterface
 * @package Port1HybridAuth\Service
 */
interface LogoutServiceInterface
{
    /**
     * Logout from all providers
     *
     * @return boolean true if the user was successfully logged out from SSO
     */
    public function logout();
}
