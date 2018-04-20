<?php
namespace Port1HybridAuth\Factory;

use Port1HybridAuth\Service\AuthenticationServiceInterface;
use Shopware\Components\DependencyInjection\Container;
use SimpleSAML\Module;

/**
 * Class AuthenticationServiceFactory
 * @package Port1HybridAuth\Factory
 */
class AuthenticationServiceFactory implements AuthenticationServiceFactoryInterface
{

    /**
     * @var Container
     */
    private $container;

    /**
     * AuthenticationServiceFactory constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container) {
        $this->container = $container;
    }


    /**
     * @param string $provider
     *
     * @return AuthenticationServiceInterface|null
     * @throws \Exception
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
