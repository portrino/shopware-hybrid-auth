<?php
namespace Port1HybridAuth\Factory;

use Port1HybridAuth\Service\AuthenticationServiceInterface;

/**
 * Class AuthenticationServiceFactory
 * @package Port1HybridAuth\Factory
 */
interface AuthenticationServiceFactoryInterface
{
    /**
     * @param string $provider
     *
     * @return AuthenticationServiceInterface|null
     */
    public function getInstance($provider);
}
