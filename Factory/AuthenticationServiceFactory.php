<?php
namespace Port1HybridAuth\Factory;

use Port1HybridAuth\Service\AuthenticationServiceInterface;
use Port1HybridAuth\Service\ConfigurationServiceInterface;
use SimpleSAML\Module;
use \Shopware\Components\DependencyInjection\Container;

/**
 * Class AuthenticationServiceFactory
 * @package Port1HybridAuth\Factory
 */
class AuthenticationServiceFactory implements AuthenticationServiceFactoryInterface
{
    /**
     * @var ConfigurationServiceInterface
     */
    private $configurationService;

    /**
     * @var Container
     */
    private $container;

    /**
     * AuthenticationServiceFactory constructor.
     *
     * @param ConfigurationServiceInterface $configurationService
     */
    public function __construct(
        ConfigurationServiceInterface $configurationService,
        Container $container
    ) {
        $this->configurationService = $configurationService;
        $this->container = $container;
    }


    /**
     * @param string $provider
     *
     * @return AuthenticationServiceInterface|null
     */
    public function getInstance($provider)
    {
        $result = null;

        if ($this->container->has('port1_hybrid_auth.' . strtolower($provider) . '_authentication_service')) {
            $result = $this->container
                ->get('port1_hybrid_auth.' . strtolower($provider) . '_authentication_service');
        }

        return $result;
    }
}
