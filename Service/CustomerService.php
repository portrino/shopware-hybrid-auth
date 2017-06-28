<?php
namespace Port1HybridAuth\Service;

/**
 * Copyright (C) portrino GmbH - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by André Wuttig <wuttig@portrino.de>, portrino GmbH
 */

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
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
            ->leftJoin('customers.attribute', 'attribute');

        if (Shopware()->Shop()->getCustomerScope() === true) {
            $builder->where('customers.shopId = ?1 AND attribute.'. strtolower($type) . 'Identity = ?2')
                ->setParameters(new ArrayCollection([
                    new Parameter(1, Shopware()->Shop()->getId()),
                    new Parameter(2, $identity)
                ]));

        } else {
            $builder->where('attribute.'. strtolower($type) . 'Identity = ?1')
                ->setParameter(1, $identity);
        }

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
        if (Shopware()->Shop()->getCustomerScope() === true) {
            $criteria = ['email' => $email, 'shopId' => Shopware()->Shop()->getId()];
        } else {
            $criteria = ['email' => $email];
        }
        $customer = $this->getRepository()->findOneBy($criteria);
        if ($customer) {
            return $customer;
        }
        return null;
    }

}
