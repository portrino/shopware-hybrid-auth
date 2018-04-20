<?php
namespace Port1HybridAuth;

use ComposerLocator;
use Shopware\Bundle\AttributeBundle\Service\CrudService;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Models\Customer\Customer;

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
     * @param InstallContext $context
     * @throws \Exception
     */
    public function install(InstallContext $context)
    {
        $this->addIdentityFieldsToUser();
        $this->activateAmazonProvider();
    }

    /**
     * @param ActivateContext $context
     * @throws \Exception
     */
    public function activate(ActivateContext $context)
    {
        $this->addIdentityFieldsToUser();
    }

    /**
     * Adds the identity attribute to the customer model.
     *
     * @return void
     * @throws \Exception
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

    /**
     * Activate Amazon provider (copy sources from additional-providers into Hybrid)
     *
     * @return void
     * @throws \Exception
     */
    private function activateAmazonProvider()
    {
        if (ComposerLocator::isInstalled('hybridauth/hybridauth')) {
            $hybridauthRootPath = ComposerLocator::getPath('hybridauth/hybridauth');
            $hybridauthAmazonPath = rtrim($hybridauthRootPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR
                . 'additional-providers' . DIRECTORY_SEPARATOR
                . 'hybridauth-amazon';
            $hybridauthHybridPath = rtrim($hybridauthRootPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR
                . 'hybridauth' . DIRECTORY_SEPARATOR
                . 'Hybrid';

            if (
                file_exists($hybridauthAmazonPath) && is_dir($hybridauthAmazonPath)
                    && file_exists($hybridauthHybridPath) && is_dir($hybridauthHybridPath)
            ) {
                $source = $hybridauthAmazonPath;
                $dest = $hybridauthHybridPath;

                /** @var \RecursiveDirectoryIterator $dirIterator */
                $dirIterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST
                );
                foreach ($dirIterator as $item) {
                    $subItem = $dest . DIRECTORY_SEPARATOR . $dirIterator->getSubPathName();
                    if ($item->isDir()) {
                        if (!file_exists($subItem)) {
                            if (!mkdir($subItem) && !is_dir($subItem)) {
                                throw new \RuntimeException(sprintf('Directory "%s" was not created', $subItem));
                            }
                        }
                    } else {
                        copy($item, $subItem);
                    }
                }
            }
        }
    }
}
