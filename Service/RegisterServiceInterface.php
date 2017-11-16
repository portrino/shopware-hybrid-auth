<?php
namespace Port1HybridAuth\Service;

use Port1HybridAuth\Model\User;
use Shopware\Models\Customer\Customer;

/**
 * Interface RegisterServiceInterface
 * @package Port1HybridAuth\Service
 */
interface RegisterServiceInterface
{
    /**
     * @param User $user
     *
     * @return Customer
     */
    public function registerCustomerByUser($user);

    /**
     * Connects a user with an existing customer
     *
     * @param User $user
     * @param Customer $customer
     *
     * @return Customer|false Customer if connecting was successful, false if not (e.g. email adresses are not equal)
     */
    public function connectUserWithExistingCustomer($user, $customer);
}
