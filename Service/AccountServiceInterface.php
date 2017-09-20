<?php
namespace Port1HybridAuth\Service;

/**
 * Copyright (C) portrino GmbH - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by André Wuttig <wuttig@portrino.de>, portrino GmbH
 */

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
