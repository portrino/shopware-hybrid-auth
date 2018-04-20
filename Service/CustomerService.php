<?php
namespace Port1HybridAuth\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Shopware\Components\Model\QueryBuilder;
use Shopware\Models\Customer\Customer;
use \Shopware\Components\DependencyInjection\Container;

/**
 * Class CustomerService
 *
 * @package Port1HybridAuth\Service
 */
class CustomerService implements CustomerServiceInterface
{

    /**
     * @var \Shopware\Models\Customer\Repository
     */
    private $repository;

    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Helper function to get access on the static declared repository
     *
     * @return \Shopware\Models\Customer\Repository
     * @throws \Exception
     */
    protected function getRepository()
    {
        if ($this->repository === null) {
            $this->repository = $this->container->get('models')->getRepository(Customer::class);
        }
        return $this->repository;
    }

    /**
     * @param string $type
     * @param string $identity
     * @return null|Customer
     * @throws \Exception
     */
    public function getCustomerByIdentity($type, $identity)
    {
        /** @var \Doctrine\ORM\QueryBuilder|QueryBuilder $builder */
        $builder = $this->container->get('models')->createQueryBuilder();
        $builder->select(['customers', 'attribute',])
                ->from('Shopware\Models\Customer\Customer', 'customers')
                ->leftJoin('customers.attribute', 'attribute');

        if ($this->container->get('shop')->getCustomerScope() === true) {
            $builder->where('customers.shopId = ?1 AND attribute.' . strtolower($type) . 'Identity = ?2')
                    ->setParameters(new ArrayCollection([
                        new Parameter(1, $this->container->get('shop')->getId()),
                        new Parameter(2, $identity)
                    ]));
        } else {
            $builder->where('attribute.' . strtolower($type) . 'Identity = ?1')
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
     * @return null|object|Customer
     * @throws \Exception
     */
    public function getCustomerByEmail($email)
    {
        /** @var Customer $customer */
        if ($this->container->get('shop')->getCustomerScope() === true) {
            $criteria = ['email' => $email, 'shopId' => $this->container->get('shop')->getId()];
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
