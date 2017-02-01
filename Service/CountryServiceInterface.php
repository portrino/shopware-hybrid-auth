<?php
namespace Port1HybridAuth\Service;

/**
 * Copyright (C) portrino GmbH - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by André Wuttig <wuttig@portrino.de>, portrino GmbH
 */

use Port1HybridAuth\Model\User;
use Shopware\Models\Country\Country;

/**
 * Interface CountryServiceInterface
 * @package Port1HybridAuth\Service
 */
interface CountryServiceInterface
{
    /**
     * @param string $isoCode
     *
     * @return null|Country
     */
    public function getCountryByCountryIso($isoCode);

    /**
     * @param int $id
     *
     * @return null|Country
     */
    public function getCountryById($id);

    /**
     * @param User $user
     *
     * @return null|Country
     */
    public function getBestMatchingCountryForUser($user);
}