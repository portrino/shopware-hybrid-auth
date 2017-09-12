<?php
namespace Port1HybridAuth\Service;

/**
 * Copyright (C) portrino GmbH - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by André Wuttig <wuttig@portrino.de>, portrino GmbH
 */

use Doctrine\DBAL\Connection;
use Port1HybridAuth\Model\User;
use Shopware\Bundle\AccountBundle\Service\AddressServiceInterface;
use Shopware\Bundle\AccountBundle\Service\Validator\CustomerValidatorInterface;
use Shopware\Bundle\StoreFrontBundle\Service\ContextServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use Shopware\Components\Model\ModelManager;
use Shopware\Components\NumberRangeIncrementerInterface;
use Shopware\Components\Password\Manager;
use Shopware\Models\Country\Country;
use Shopware\Models\Customer\Address;
use Shopware\Models\Customer\Customer;
use Shopware_Components_Config;

/**
 * Class RegisterService
 * @package Port1HybridAuth\Service
 */
class CountryService implements CountryServiceInterface
{
    /**
     * @var \Shopware\Models\Country\Repository
     */
    private $repository;

    /**
     * @return \Shopware\Models\Country\Repository
     */
    public function getRepository()
    {
        if ($this->repository === null) {
            $this->repository = Shopware()->Models()->getRepository(Country::class);
        }
        return $this->repository;
    }

    /**
     * @param string $isoCode
     *
     * @return null|Country
     */
    public function getCountryByCountryIso($isoCode)
    {
        /** @var Country $country */
        $country = $this->getRepository()->findOneBy(['iso' => $isoCode]);
        if ($country) {
            return $country;
        }
        return null;
    }

    /**
     * @param string $countryEn
     *
     * @return null|Country
     */
    public function getCountryByIsoName($countryEn)
    {
        /** @var Country $country */
        $country = $this->getRepository()->findOneBy(['isoName' => $countryEn]);
        if ($country) {
            return $country;
        }
        return null;
    }

    /**
     * @param string $countryName
     *
     * @return null|Country
     */
    public function getCountryByCountryName($countryName)
    {
        /** @var Country $country */
        $country = $this->getRepository()->findOneBy(['name' => $countryName]);
        if ($country) {
            return $country;
        }
        return null;
    }

    /**
     * @param int $id
     *
     * @return null|Country
     */
    public function getCountryById($id)
    {
        /** @var Country $country */
        $country = $this->getRepository()->find($id);
        if ($country) {
            return $country;
        }
        return null;
    }

    /**
     * @param User $user
     *
     * @return null|Country
     */
    public function getBestMatchingCountryForUser($user)
    {
        $result = null;
        if ($user->getCountryIso()) {
            $result = $this->getCountryByCountryIso($user->getCountryIso());
        }
        if ($result === null) {
            if ($user->getCountryName()) {
                $result = $this->getCountryByIsoName($user->getCountryName());
            }
        }

        if ($result === null) {
            if ($user->getCountryName()) {
                $result = $this->getCountryByCountryName($user->getCountryName());
            }
        }
        return $result;
    }
}
