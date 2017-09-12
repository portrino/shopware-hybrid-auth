<?php
namespace Port1HybridAuth\Service;

/**
 * Copyright (C) portrino GmbH - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by André Wuttig <wuttig@portrino.de>, portrino GmbH
 */

/**
 * Interface ConfigurationServiceInterface
 * @package Port1HybridAuth\Service
 */
interface ConfigurationServiceInterface
{
    /**
     * Returns all configured authsources
     *
     * @return array
     */
    public function getEnabledProviders();

    /**
     * Returns true if the given provider is enabled (e.g.: Facebook, LinkedIn, OpenID, Google)
     *
     * @param string $provider
     *
     * @return boolean
     */
    public function isProviderEnabled($provider);

    /**
     * Returns all configurations for all providers
     *
     * @return array
     */
    public function getAllProviderConfigurations();

    /**
     * Returns the config for the given provider (e.g.: Facebook, LinkedIn, OpenID, Google)
     *
     * @param string $provider
     *
     * @return array
     */
    public function getProviderConfiguration($provider);
}
