<?php

namespace Port1HybridAuth\Service;

/**
 * Copyright (C) portrino GmbH - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by André Wuttig <wuttig@portrino.de>, portrino GmbH
 */

use Port1HybridAuth\Model\User;
use Port1HybridAuth\Service\AbstractAuthenticationService;
use Port1HybridAuth\Service\ConfigurationServiceInterface;

/**
 * Class LogoutService
 * @package Port1HybridAuth\Service
 */
class LogoutService implements LogoutServiceInterface
{
    /**
     * @var ConfigurationServiceInterface
     */
    protected $configurationService;

    /**
     * @var \Hybrid_Auth
     */
    protected $hybridAuth;

    /**
     * GenericAuthenticationService constructor.
     *
     * @param string $provider
     * @param ConfigurationServiceInterface $configurationService
     */
    public function __construct(
        ConfigurationServiceInterface $configurationService
    ) {
    
        $this->configurationService = $configurationService;
    }

    /**
     * @return boolean true if the user was successfully logged out from SSO
     */
    public function logout()
    {
        $result = false;

        $configurations = $this->configurationService->getAllProviderConfigurations();

        if (count($configurations)) {
            $this->hybridAuth = new \Hybrid_Auth($configurations);

            if ($this->hybridAuth) {
                $result = $this->hybridAuth->logoutAllProviders();
            }
        }

        return $result;
    }
}
