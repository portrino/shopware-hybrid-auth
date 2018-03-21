<?php
namespace Port1HybridAuth;

use Shopware\Bundle\AttributeBundle\Service\CrudService;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\InstallContext;

use Exception;

// require our composer dependencies, if not already
if (file_exists(sprintf('%1$s%2$svendor%2$sautoload.php', __DIR__, DIRECTORY_SEPARATOR))) {
    require_once sprintf('%1$s%2$svendor%2$sautoload.php', __DIR__, DIRECTORY_SEPARATOR);
}

/**
 * Class Port1HybridAuth
 * @package Port1HybridAuth
 */
class Port1HybridAuth extends Plugin
{
    const PROVIDERS = [
        'Amazon',
        'Google',
        'Facebook',
        'LinkedIn',
//        unfortunatly windows live login doesn`t work after hours of bugfixing against M$ oauth
//        'Live'
    ];

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [];
    }

    /**
     * @param InstallContext $context
     */
    public function install(InstallContext $context)
    {
        $this->addIdentityFieldsToUser();
    }

    /**
     * @param ActivateContext $context
     */
    public function activate(ActivateContext $context)
    {
        $this->addIdentityFieldsToUser();
    }

    /**
     * Adds the identity attribute to the customer model.
     *
     * @return void
     */
    private function addIdentityFieldsToUser()
    {

        /** @var CrudService $service */
        $service = $this->container->get('shopware_attribute.crud_service');

        foreach (self::PROVIDERS as $provider) {
            $service->update('s_user_attributes', strtolower($provider) . '_identity', 'string', [
                'label' => 'Identity ' . $provider,

                //user has the opportunity to translate the attribute field for each shop
                'translatable' => false,

                //attribute will be displayed in the backend module
                'displayInBackend' => true,

                //in case of multi_selection or single_selection type, article entities can be selected,
                'entity' => Customer::class,

                //numeric position for the backend view, sorted ascending
                'position' => 100,

                //user can modify the attribute in the free text field module
                'custom' => false,
            ]);
        }

        $models = $this->container->get('models');
        $metaDataCache = $models->getConfiguration()->getMetadataCacheImpl();
        $metaDataCache->deleteAll();
        $models->generateAttributeModels(['s_user_attributes']);
    }
}
