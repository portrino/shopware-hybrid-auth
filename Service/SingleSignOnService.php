<?php
namespace Port1HybridAuth\Service;

use Port1HybridAuth\Factory\AuthenticationServiceFactoryInterface;
use Shopware\Components\DependencyInjection\Container;
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
     * @var Container
     */
    protected $container;

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
     * @param Container $container
     */
    public function __construct(Container $container) {
        $this->container = $container;

        $this->authenticationServiceFactory = $this->container->get('port1_hybrid_auth.authentication_service_factory');
        $this->customerService = $this->container->get('port1_hybrid_auth.customer_service');
        $this->accountService = $this->container->get('port1_hybrid_auth.account_service');
        $this->registerService = $this->container->get('port1_hybrid_auth.register_service');
        $this->logoutService = $this->container->get('port1_hybrid_auth.logout_service');
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

        // active sw login session
        if ($isUserLoggedIn) {
            return $isUserLoggedIn;
        }

        if ($this->authenticationService !== null) {
            // sso login
            $isAuthenticated = $this->authenticationService->login();
            $customer = null;
            if ($isAuthenticated) {
                // get user data from sso provider
                $user = $this->authenticationService->getUser();
                if ($user !== null && $user->getEmail() !== '') {
                    // get sw customer
                    $customer = $this->customerService->getCustomerByIdentity($provider, $user->getId());
                    if ($customer !== null) {
                        // new login
                        $isUserLoggedIn = $this->tryLoginCustomer($customer);
                    } else {
                        $customer = $this->customerService->getCustomerByEmail($user->getEmail());
                        if ($customer !== null) {
                            // connect
                            $customer = $this->registerService->connectUserWithExistingCustomer($user, $customer);
                        } else {
                            // register
                            $customer = $this->registerService->registerCustomerByUser($user);
                        }
                        $isUserLoggedIn = $this->tryLoginCustomer($customer);
                    }
                }
            } else {
                $isUserLoggedIn = false;
            }

            $this->container->get('events')->notify(
                'Port1HybridAuth_Service_SingleSignOn_CustomerLoggedIn',
                [
                    'customer' => $customer,
                    'isUserLoggedIn' => $isUserLoggedIn
                ]
            );
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

        if ($customer !== null) {
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
