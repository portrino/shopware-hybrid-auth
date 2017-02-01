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
 * Class CustomerService
 * @package Port1HybridAuth\Service
 */
class CustomerService implements CustomerServiceInterface
{
    /**
     * @var \Shopware\Models\Customer\Repository
     */
    private $repository;

    /**
     * Helper function to get access on the static declared repository
     *
     * @return null|\Shopware\Models\Customer\Repository
     */
    protected function getRepository()
    {
        if ($this->repository === null) {
            $this->repository = Shopware()->Models()->getRepository(Customer::class);
        }
        return $this->repository;
    }

    /**
     * @param string $type
     * @param string $identity
     *
     * @return Customer|null
     */
    public function getCustomerByIdentity($type, $identity)
    {
        $builder = Shopware()->Models()->createQueryBuilder();
        $builder->select(['customers', 'attribute',])
            ->from('Shopware\Models\Customer\Customer', 'customers')
            ->leftJoin('customers.attribute', 'attribute')
            ->where('attribute.'. strtolower($type) . 'Identity = ?1')
            ->setParameter(1, $identity);

        $customer = $builder->getQuery()->getOneOrNullResult(1);

        if ($customer) {
            return $customer;
        }
        return null;
    }

    /**
     * @param string $email
     *
     * @return Customer|null
     */
    public function getCustomerByEmail($email)
    {
        /** @var Customer $customer */
        $customer = $this->getRepository()->findOneBy(['email' => $email]);
        if ($customer) {
            return $customer;
        }
        return null;
    }

}
