<?php

namespace Port1HybridAuth\Service;

use Port1HybridAuth\Port1HybridAuth;
use Shopware\Bundle\StoreFrontBundle\Service\ContextServiceInterface;

/**
 * Class ConfigurationService
 * @package Port1HybridAuth\Service
 */
class ConfigurationService implements ConfigurationServiceInterface
{


    /**
     * @var ContextServiceInterface
     */
    protected $context;

    /**
     * @var \Shopware_Components_Config
     */
    protected $config;

    /**
     * @var \Shopware_Components_Snippet_Manager
     */
    protected $snippetManager;

    /**
     * ConfigurationService constructor.
     *
     * @param ContextServiceInterface $context
     * @param \Shopware_Components_Config $config
     * @param \Shopware_Components_Snippet_Manager $snippetManager
     */
    public function __construct(
        ContextServiceInterface $context,
        \Shopware_Components_Config $config,
        \Shopware_Components_Snippet_Manager $snippetManager
    ) {
        $this->context = $context;
        $this->config = $config;
        $this->snippetManager = $snippetManager;
    }


    /**
     * Returns all enabled providers
     *
     * @return array
     */
    public function getEnabledProviders()
    {
        $result = [];

        foreach (Port1HybridAuth::PROVIDERS as $provider) {
            if ((Boolean)$this->config->getByNamespace('Port1HybridAuth', strtolower($provider) . '_enabled')) {
                $label = $this->snippetManager->getNamespace('frontend/account/login')->get('SignInWith' . $provider);

                $result[$provider] = $label;
            }
        }

        return $result;
    }

    /**
     * Returns all enabled providers
     *
     * @param string $provider
     *
     * @return bool
     */
    public function isProviderEnabled($provider)
    {
        return (Boolean)$this->config->getByNamespace('Port1HybridAuth', strtolower($provider) . '_enabled');
    }

    /**
     * Returns all configurations for all providers
     *
     * @return array
     */
    public function getAllProviderConfigurations()
    {
        $result = [];

        foreach (Port1HybridAuth::PROVIDERS as $PROVIDER) {
            $config = $this->getProviderConfiguration($PROVIDER);

            if ($config != false) {
                $result = array_replace_recursive($result, $this->getProviderConfiguration($PROVIDER));
            }
        }
        return $result;
    }

    /**
     * Returns the config for the given provider (e.g.: Facebook, LinkedIn, OpenID, Google)
     *
     * @param string $provider
     *
     * @return array|bool
     */
    public function getProviderConfiguration($provider)
    {
        $result = false;

        if ($this->isProviderEnabled($provider)) {
            $result = $this->getProviderConfigurationFromConfigFile($provider);
        }

        return $result;
    }


    /**
     * Returns the config for the given provider (e.g.: Facebook, LinkedIn, OpenID, Google)
     *
     * @param string $provider
     * @param string $configFile
     * @param string $namespace
     *
     * @return array|bool
     * @throws \Exception
     */
    public function getProviderConfigurationFromConfigFile(
        $provider,
        $configFile = null,
        $namespace = 'Port1HybridAuth'
    ) {
        $configFile = (!is_null($configFile) ? $configFile : realpath(sprintf('%1$s%2$s..%2$sConfiguration%2$sconfig.php', __DIR__, DIRECTORY_SEPARATOR)));

        if (!file_exists($configFile)) {
            throw new \Exception('Hybridauth config does not exist on the given path.', 1);
        }

        $configTemplate = include $configFile;
        $result = false;

        if (is_array($configTemplate)) {
            $baseUrl = $this->context->getShopContext()->getBaseUrl();
            $virtualUrl = $this->context->getShopContext()->getShop()->getUrl();

            $url = rtrim($baseUrl, '/') . rtrim($virtualUrl, '/') . '/hybridauth';

            $result = [
                'base_url' => $url,
                'debug_mode' => (Boolean)$this->config->getByNamespace('Port1HybridAuth', 'debug_mode'),
                'debug_file' => $this->config->getByNamespace('Port1HybridAuth', 'debug_file'),
            ];

            if (isset($configTemplate['providers'][$provider])) {
                $result['providers'][$provider] = ['enabled' => true];

                $providerConfiguration = $this->flatten($configTemplate['providers'][$provider]);

                foreach ($providerConfiguration as $configurationKey => $configuration) {
                    if (is_array($configuration)) {
                        $configValue = $this->config->getByNamespace(
                            $namespace,
                            strtolower($provider) . '_' . $configurationKey
                        );
                        if (empty($configValue) === false) {
                            $configValue = explode(',', $configValue);
                        } else {
                            $configValue = [];
                        }
                    }

                    if (is_bool($configuration)) {
                        $configValue = (Boolean)$this->config->getByNamespace(
                            $namespace,
                            strtolower($provider) . '_' . $configurationKey
                        );
                    }

                    if (is_string($configuration)) {
                        $configValue = (string)$this->config->getByNamespace(
                            $namespace,
                            strtolower($provider) . '_' . $configurationKey
                        );
                    }

                    // set the default config value if no override takes place
                    if (empty($configValue)) {
                        $configValue = $configuration;
                    }

                    $this->setNestedArrayValue($result['providers'][$provider], $configurationKey, $configValue);
                }
            }
        }

        return $result;
    }

    /**
     * @param array $array
     * @param string $prefix
     *
     * @return array
     */
    protected function flatten($array, $prefix = '')
    {
        $result = [];

        foreach ($array as $key => $value) {
            // hacky solution to prevent underscore interpretation
            if (strpos($key, '_') > 0) {
                $key = str_replace('_', '###', $key);
            }

            if (is_array($value) && count($value) > 0) {
                $result = $result + $this->flatten($value, $prefix . $key . '_');
            } else {
                $result[$prefix . $key] = $value;
            }
        }

        return $result;
    }


    /**
     * Sets a value in a nested array based on path
     * See http://stackoverflow.com/a/9628276/419887
     *
     * @param array $array The array to modify
     * @param string $path The path in the array
     * @param mixed $value The value to set
     * @param string $delimiter The separator for the path
     *
     * @return mixed the previous value
     */
    protected function setNestedArrayValue(&$array, $path, &$value, $delimiter = '_')
    {
        $pathParts = explode($delimiter, $path);

        $current = &$array;
        foreach ($pathParts as $key) {
            // hacky solution to prevent underscore intepretation
            if (strpos($key, '###') > 0) {
                $key = str_replace('###', '_', $key);
            }

            $current = &$current[$key];
        }

        $backup = $current;
        $current = $value;

        return $backup;
    }
}
