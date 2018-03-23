<?php
namespace Port1HybridAuth\Service;

use Port1HybridAuth\Model\User;
use Shopware\Models\Customer\Customer;

/**
 * Interface CustomerServiceInterface
 *
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
