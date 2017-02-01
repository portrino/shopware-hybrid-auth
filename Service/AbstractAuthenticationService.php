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
 * Class AbstractAuthenticationService
 * @package Port1HybridAuth\Service
 */
abstract class AbstractAuthenticationService implements AuthenticationServiceInterface
{
    /**
     * @var ConfigurationServiceInterface
     */
    protected $configurationService;

    /**
     * @var string
     */
    protected $provider;

    /**
     * @var \Hybrid_Auth
     */
    protected $hybridAuth;

    /**
     * @var \Hybrid_Provider_Adapter
     */
    protected $adapter;

    /**
     * AbstractAuthenticationService constructor.
     *
     * @param string $provider
     * @param ConfigurationServiceInterface $configurationService
     */
    public function __construct(
        $provider,
        ConfigurationServiceInterface $configurationService)
    {
        $this->provider = $provider;
        $this->configurationService = $configurationService;

        $config = $this->configurationService->getProviderConfiguration($this->provider);

        $this->hybridAuth = new \Hybrid_Auth($config);
    }

    /**
     * @return boolean true if the user is authenticated
     */
    public function login()
    {
        $result = false;

        $this->adapter = $this->hybridAuth->authenticate($this->provider);

        if ($this->isAuthenticated()) {
            $result = true;
        }

        return $result;
    }

    /**
     * @return boolean true if the user was successfully logged out from SSO
     */
    public function logout()
    {
        $result = false;

        if ($this->adapter) {
            $result = $this->adapter->logout();
        }

        return $result;
    }

    /**
     * @return \Hybrid_User_Profile|null
     */
    protected function getUserProfile()
    {
        $result = null;
        if ($this->isAuthenticated()) {
            $result = $this->adapter->getUserProfile();
        }
        return $result;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {

        $user = null;

        if ($this->isAuthenticated()) {

            $userProfil = $this->getUserProfile();

            if ($userProfil != null) {

                $identifier = empty($userProfil->identifier) === false ? $userProfil->identifier : false;
                $email = empty($userProfil->emailVerified) === false ? $userProfil->emailVerified : $userProfil->email;

                if (empty($identifier) === false && empty($email) === false) {
                    $user = new User(strtolower($this->provider), $identifier, $email);

                    if (empty($userProfil->gender) === false) {

                        if ($userProfil->gender === 'male') {
                            $user->setSalutation('mr');
                        }

                        if ($userProfil->gender === 'female') {
                            $user->setSalutation('ms');
                        }
                    }

                    if (empty($userProfil->firstName) === false) {
                        $user->setFirstName($userProfil->firstName);
                    }

                    if (empty($userProfil->lastName) === false) {
                        $user->setLastName($userProfil->lastName);
                    }

                    if (empty($userProfil->city) === false) {
                        $user->setCity($userProfil->city);
                    }

                    if (empty($userProfil->zip) === false) {
                        $user->setZip($userProfil->zip);
                    }

                    if (empty($userProfil->address) === false) {
                        $user->setAddress($userProfil->address);
                    }

                    if (empty($userProfil->country) === false) {
                        $user->setCountryName($userProfil->country);
                    }

                    if (empty($userProfil->language) === false) {
                        $user->setLocale($userProfil->country);
                    }
                }

            }
        }

        return $user;
    }

    /**
     *
     * @return boolean true if the user is authenticated
     */
    public function isAuthenticated()
    {
        return ($this->adapter != null && $this->adapter->isUserConnected());
    }

}