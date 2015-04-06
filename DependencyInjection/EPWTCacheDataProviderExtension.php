<?php

namespace EPWT\Cache\DataProviderBundle\DependencyInjection;

use EPWT\Cache\DataProviderBundle\Exception\CacheDriverNotFoundException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class EPWTCacheDataProviderExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $cacheDriverName = 'epwt_data_provider.cache_driver.' . $config['cache_driver'];

        if (!$container->has($cacheDriverName)) {
            throw new CacheDriverNotFoundException($config['cache_driver']);
        }

        $container->setAlias('epwt_data_provider.cache_driver', $cacheDriverName);
    }
}
