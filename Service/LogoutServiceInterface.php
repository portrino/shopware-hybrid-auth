<?php
namespace Port1HybridAuth\Service;

/**
 * Copyright (C) portrino GmbH - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by André Wuttig <wuttig@portrino.de>, portrino GmbH
 */

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