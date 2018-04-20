<?php
namespace Port1HybridAuth\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Components\DependencyInjection\Container;

/**
 * Class AbstractSubscriber
 *
 * @package Port1HybridAuth\Subscriber
 */
abstract class AbstractSubscriber implements SubscriberInterface
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var string
     */
    protected $path;

    /**
     * BaseSubscriber constructor.
     *
     * @param Container $container
     * @param string $path
     */
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
     * list($controller, $request, $view) = self::getEverythingFromArgs($args);
     *
     * @param \Enlight_Event_EventArgs $args
     * @param null $element
     * @return array|mixed|null
     */
    final public static function getEverythingFromArgs(\Enlight_Event_EventArgs $args, $element = null)
    {
        /**
         * @var \Enlight_Controller_Action $controller
         */
        $controller = $args->get('subject');

        /**
         * @var \Enlight_Controller_Request_Request $request
         */
        $request = $controller->Request();

        /**
         * @var \Enlight_View_Default $view
         */
        $view = $controller->View();

        $result = [
            'controller' => $controller,
            'request' => $request,
            'view' => $view
        ];

        if ($element !== null) {
            if (array_key_exists($element, $result)) {
                $result = $result[$element];
            } else {
                $result = null;
            }
        }

        return $result;
    }
}
