<?php
namespace Port1HybridAuth\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Components\DependencyInjection\Container;

abstract class BaseSubscriber implements SubscriberInterface
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var string
     */
    protected $path = null;

    public function __construct(Container $container, $path = null)
    {
        $this->container = $container;
        $this->path = $path;
    }

    /**
     * Gets the Plugin directory path.
     *
     * @return string The Plugin absolute path
     */
    final public function getPath()
    {
        if (null === $this->path) {
            $reflected = new \ReflectionObject($this);
            $this->path = dirname($reflected->getFileName());
        }

        return $this->path;
    }

    /**
     * Returns an array in the form of var association:
     * list($controller, $request, $view) = self::getEverytihngFromArgs($args);
     *
     * @param $args
     *
     * @return array
     */
    final public static function getEverytihngFromArgs ($args)
    {
        /**
         * @var \Enlight_Controller_Action $controller
         */
        $controller = $args->getSubject();
        /**
         * @var \Enlight_Controller_Request_Request $request
         */
        $request = $controller->Request();

        /**
         * @var \Enlight_View_Default $view
         */
        $view = $controller->View();

        return array(
            $controller,
            $request,
            $view
        );
    }
}
