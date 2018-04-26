<?php
namespace Port1HybridAuth\Service;

use Doctrine\DBAL\Connection;
use Exception;
use Port1HybridAuth\Model\User;
use Shopware\Bundle\AccountBundle\Service\AddressServiceInterface;
use Shopware\Bundle\AccountBundle\Service\Validator\CustomerValidatorInterface;
use Shopware\Bundle\StoreFrontBundle\Service\ContextServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use Shopware\Components\Model\ModelManager;
use Shopware\Components\NumberRangeIncrementerInterface;
use Shopware\Components\Password\Manager;
use Shopware\Models\Customer\Address;
use Shopware\Models\Customer\Customer;
use Shopware_Components_Config;

/**
 * Class RegisterService
 * @package Port1HybridAuth\Service
 */
class RegisterService extends \Shopware\Bundle\AccountBundle\Service\RegisterService implements RegisterServiceInterface
{

    /**
     * @var ModelManager
     */
    private $modelManager;

    /**
     * @var CustomerValidatorInterface
     */
    private $validator;

    /**
     * @var ContextServiceInterface
     */
    private $context;

    /**
     * @var CountryServiceInterface
     */
    private $countryService;

    /**
     * RegisterService constructor.
     *
     * @param ContextServiceInterface $context
     * @param ModelManager $modelManager
     * @param CustomerValidatorInterface $validator
     * @param Shopware_Components_Config $config
     * @param Manager $passwordManager
     * @param NumberRangeIncrementerInterface $numberIncrementer
     * @param Connection $connection
     * @param AddressServiceInterface $addressService
     * @param CountryServiceInterface $countryService
     */
    public function __construct(
        ContextServiceInterface $context,
        ModelManager $modelManager,
        CustomerValidatorInterface $validator,
        Shopware_Components_Config $config,
        Manager $passwordManager,
        NumberRangeIncrementerInterface $numberIncrementer,
        Connection $connection,
        AddressServiceInterface $addressService,
        CountryServiceInterface $countryService
    ) {
        $this->context = $context;
        $this->modelManager = $modelManager;
        $this->validator = $validator;
        $this->countryService = $countryService;
        parent::__construct(
            $modelManager,
            $validator,
            $config,
            $passwordManager,
            $numberIncrementer,
            $connection,
            $addressService
        );
    }

    /**
     * @param User $user
     *
     * @return Customer
     */
    public function registerCustomerByUser($user)
    {

        /** @var ShopContextInterface $context */
        $context = $this->context->getShopContext();
        $shop = $context->getShop();

        $customer = new Customer();

        $customer->setAttribute([strtolower($user->getType()) . 'Identity' => $user->getId()]);

        $customer->setSalutation($user->getSalutation());
        $customer->setEmail($user->getEmail());
        $customer->setFirstname($user->getFirstName());
        $customer->setLastname($user->getLastName());
        // we generate the password here, because we have no password
        // due the SSO mechanism and we will not neet it in future
        // But SW needs it :-)
        $password = uniqid();
        $customer->setPassword($password);

        $billing = new Address();
        $billing->setCompany($user->getCompany());
        $billing->setSalutation($user->getSalutation());
        $billing->setFirstname($user->getFirstName());
        $billing->setLastname($user->getLastName());
        $billing->setCity($user->getCity());
        $billing->setStreet($user->getAddress());
        $billing->setZipcode($user->getZip());

        // try to find the best matching country for the user
        $country = $this->countryService->getBestMatchingCountryForUser($user);

        // try to find the matching country by the current locale of the shop
        if ($country === null) {
            $defaultCountry = Shopware()->Config()->getByNamespace('Port1HybridAuth', 'general_default_country');
            if ($defaultCountry) {
                $country = $this->countryService->getCountryById($defaultCountry);
            }
        }

        // take germany if no country could be found
        if ($country === null) {
            $country = $this->countryService->getCountryByCountryIso('de');
        }

        $billing->setCountry($country);

        try {
            $this->register($shop, $customer, $billing);
        } catch (Exception $ex) {
            return null;
        }

        return $customer;
    }

    /**
     * Connects a user with an existing customer
     *
     * @param User $user
     * @param Customer $customer
     *
     * @return Customer|false Customer if connecting was successful, false if not (e.g. email adresses are not equal)
     */
    public function connectUserWithExistingCustomer($user, $customer)
    {
        $result = false;
        if ($user->getEmail() === $customer->getEmail()) {
            \call_user_func(
                [$customer->getAttribute(), 'set' . ucfirst($user->getType()) . 'Identity'],
                $user->getId()
            );
            $result = $this->udapteCustomerAttributes($customer);
        }

        return $result;
    }

    /**
     * @param Customer $customer
     *
     * @return Customer|false
     */
    protected function udapteCustomerAttributes($customer)
    {
        try {
            $this->validator->validate($customer);

            $this->modelManager->persist($customer->getAttribute());
            $this->modelManager->flush($customer->getAttribute());
            $this->modelManager->refresh($customer->getAttribute());

            return $customer;
        } catch (Exception $ex) {
            return false;
        }
    }
}
