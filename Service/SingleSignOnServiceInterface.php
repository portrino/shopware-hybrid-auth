<?php
namespace Port1HybridAuth\Service;

/**
 * Class SingleSignOnServiceInterface
 * @package Port1HybridAuth\Service
 */
interface SingleSignOnServiceInterface
{
    /**
     * the overall method for the SSO workflow
     *
     * @param $provider string the authsource string (e.g.: linkedin, ...)
     * @return bool
     */
    public function loginAndRegisterVia($provider);

    /**
     * logout from provider
     *
     * @return bool TRUE if the logout was successful, FALSE if not
     */
    public function logout();
}
