<?php
namespace Port1HybridAuth\Service;

/**
 * Copyright (C) portrino GmbH - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by André Wuttig <wuttig@portrino.de>, portrino GmbH
 */

use Port1HybridAuth\Model\User;

/**
 * Class SamlAuthenticationService
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
