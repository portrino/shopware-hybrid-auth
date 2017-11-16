<?php
namespace Port1HybridAuth\Factory;


use Port1HybridAuth\Service\AuthenticationServiceInterface;
use Port1HybridAuth\Service\ConfigurationServiceInterface;
use SimpleSAML\Module;

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
     * AuthenticationServiceFactory constructor.
     *
     * @param ConfigurationServiceInterface $configurationService
     */
    public function __construct(
        ConfigurationServiceInterface $configurationService
    ) {
        $this->configurationService = $configurationService;
    }


    /**
     * @param string $provider
     *
     * @return AuthenticationServiceInterface|null
     */
    public function getInstance($provider)
    {
        $result = null;

        if (Shopware()->Container()->has('port1_hybrid_auth.' . strtolower($provider) . '_authentication_service')) {
            $result = Shopware()
                ->Container()
                ->get('port1_hybrid_auth.' . strtolower($provider) . '_authentication_service');
        }

        return $result;
    }
}
