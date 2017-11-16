<?php
namespace Port1HybridAuth\Service;

use Shopware\Models\Customer\Customer;

/**
 * Interface AccountServiceInterface
 * @package Port1HybridAuth\Service
 */
interface AccountServiceInterface
{
    /**
     * Checks if user is correctly logged in. Also checks session timeout
     *
     * @return bool
     */
    public function checkUser();

    /**
     * Logs in the user for the given customer object
     *
     * @param Customer $customer
     *
     * @return bool|array
     */
    public function loginUser($customer);
}
