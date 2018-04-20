<?php
namespace Port1HybridAuth\Service;

use Port1HybridAuth\Model\User;
use Shopware\Components\DependencyInjection\Container;
use Shopware\Models\Country\Country;

/**
 * Class CountryService
 *
 * @package Port1HybridAuth\Service
 */
class CountryService implements CountryServiceInterface
{
    /**
     * @var \Shopware\Models\Country\Repository
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
     * @return \Shopware\Models\Country\Repository
     * @throws \Exception
     */
    public function getRepository()
    {
        if ($this->repository === null) {
            $this->repository = $this->container->get('models')->getRepository(Country::class);
        }
        return $this->repository;
    }

    /**
     * @param string $isoCode
     * @return null|Country
     * @throws \Exception
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
     * @param $countryEn
     * @return null|Country
     * @throws \Exception
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
     * @param $countryName
     * @return null|Country
     * @throws \Exception
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
     * @return null|Country
     * @throws \Exception
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
     * @return null|Country
     * @throws \Exception
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
