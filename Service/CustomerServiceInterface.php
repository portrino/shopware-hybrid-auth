<?php
namespace Port1HybridAuth\Service;

/**
 * Copyright (C) portrino GmbH - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by André Wuttig <wuttig@portrino.de>, portrino GmbH
 */

use Port1HybridAuth\Model\User;
use Shopware\Models\Customer\Customer;

/**
 * Interface CustomerServiceInterface
 * @package Port1HybridAuth\Service
 */
interface CustomerServiceInterface
{
    /**
     * @param string $email
     *
     * @return Customer|null
     */
    public function getCustomerByEmail($email);

    /**
     * @param string $type
     * @param string $identity
     *
     * @return Customer|null
     */
    public function getCustomerByIdentity($type, $identity);
}
