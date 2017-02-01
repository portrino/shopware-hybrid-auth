<?php

namespace Port1HybridAuth\Service;

/**
 * Copyright (C) portrino GmbH - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by André Wuttig <wuttig@portrino.de>, portrino GmbH
 */

use Port1HybridAuth\Factory\AuthenticationServiceFactoryInterface;
use Shopware\Models\Customer\Customer;

/**
 * Class SingleSignOnService
 * @package Port1HybridAuth\Service
 */
class SingleSignOnService implements SingleSignOnServiceInterface
{
    /**
     * @var \sAdmin
     */
    protected $admin;

    /**
     * @var CustomerServiceInterface
     */
    private $customerService;

    /**
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * @var AuthenticationServiceInterface|AbstractAuthenticationService
     */
    private $authenticationService;

    /**
     * @var RegisterServiceInterface
     */
    private $registerService;

    /**
     * @var LogoutServiceInterface
     */
    private $logoutService;

    /**
     * @var AuthenticationServiceFactoryInterface
     */
    private $authenticationServiceFactory;

    /**
     * SingleSignOnService constructor.
     *
     * @param AuthenticationServiceFactoryInterface $authenticationServiceFactory
     * @param CustomerServiceInterface $customerService
     * @param AccountServiceInterface $accountService
     * @param RegisterServiceInterface $registerService
     */
    public function __construct(
        AuthenticationServiceFactoryInterface $authenticationServiceFactory,
        CustomerServiceInterface $customerService,
        AccountServiceInterface $accountService,
        RegisterServiceInterface $registerService,
        LogoutServiceInterface $logoutService
    ) {
        $this->authenticationServiceFactory = $authenticationServiceFactory;
        $this->customerService = $customerService;
        $this->accountService = $accountService;
        $this->registerService = $registerService;
        $this->logoutService = $logoutService;
    }

    /**
     * the overall method for the SSO workflow login + register
     *
     * @param $provider string the authsource string (e.g.: linkedin, ...)
     * @return bool
     */
    public function loginAndRegisterVia($provider)
    {
        $this->authenticationService = $this->authenticationServiceFactory->getInstance($provider);

        $isUserLoggedIn = $this->accountService->checkUser();

        /**
         * SW LOGIN
         */
        if ($isUserLoggedIn) {
            return $isUserLoggedIn;
        } else {

            if ($this->authenticationService != null) {

                /**
                 * SSO LOGIN
                 */
                $isAuthenticated = $this->authenticationService->login();

                if ($isAuthenticated) {

                    /**
                     * GET USER DATA FROM SSO PROVIDER
                     */
                    $user = $this->authenticationService->getUser();

                    if ($user != null && $user->getEmail() != '') {

                        /**
                         * GET SW CUSTOMER
                         */
                        $customer = $this->customerService->getCustomerByIdentity($provider, $user->getId());

                        if ($customer != null) {

                            /**
                             * NEW LOGIN
                             */
                            $isUserLoggedIn = $this->tryLoginCustomer($customer);
                        } else {
                            $customer = $this->customerService->getCustomerByEmail($user->getEmail());
                            if ($customer != null) {

                                /**
                                 * CONNECT
                                 */
                                $customer = $this->registerService->connectUserWithExistingCustomer($user, $customer);
                                $isUserLoggedIn = $this->tryLoginCustomer($customer);
                            } else {

                                /**
                                 * REGISTER
                                 */
                                $customer = $this->registerService->registerCustomerByUser($user);
                                $isUserLoggedIn = $this->tryLoginCustomer($customer);
                            }
                        }
                    }
                } else {
                    $isUserLoggedIn = false;
                }
            }
        }
        return $isUserLoggedIn;
    }

    /**
     * @param Customer $customer
     *
     * @return bool true if the customer is successfully logged in, false if not
     */
    protected function tryLoginCustomer($customer = null)
    {
        $result = false;

        if ($customer != null) {
            $checkUser = $this->accountService->loginUser($customer);
            if (empty($checkUser['sErrorMessages'])) {
                $result = true;
            }
        } else {
            /**
             * this could happen because we do not get all the data from the SSO Provider
             * and cannot create a valid user via RegisterService
             */
            $result = false;
        }

        return $result;
    }

    /**
     * logout from all providers
     *
     * @return bool TRUE if the logout was successful, FALSE if not
     */
    public function logout()
    {
        return $this->logoutService->logout();
    }
}