<?php

namespace EPWT\Cache\DataProviderBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AddProviderPass
 * @package EPWT\Cache\DataProviderBundle\DependencyInjection\Compiler
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
class AddProvidersPass implements CompilerPassInterface
{
    const TYPES_CONTAINER_ID = 'epwt_data_provider.types.container';

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     * @return bool
     */
    public function process(ContainerBuilder $container)
    {
        $taggedProviders = $container->findTaggedServiceIds('epwt_data_provider');

        /** @var Definition[] $typesContainers */
        $typesContainers = [];

        foreach ($taggedProviders as $id => $tags) {
            $tag = reset($tags);
            $providerType = $tag['type'];
            $providerName = $tag['title'];

            if (!isset($typesContainers[$providerType])) {
                $typesContainers[$providerType] = $container->getDefinition(
                    $container->getAlias(
                        'epwt_data_provider.types.container.' . $providerType
                    )
                );
            }

            $typesContainers[$providerType]->addMethodCall(
                'addProvider',
                [
                    $providerName,
                    new Reference($id)
                ]
            );

            $definition = $container->getDefinition($id);

            $definition->addMethodCall(
                'setCacheDriver',
                [
                    new Reference('epwt_data_provider.cache_driver')
                ]
            );

            $definition->addMethodCall(
                'setContainer',
                [
                    new Reference('service_container')
                ]
            );

            $definition->addMethodCall(
                'setProvidersContainer',
                [
                    new Reference('epwt_data_provider.types.container.' . $providerType)
                ]
            );

            $definition->addMethodCall(
                'setProviderTypesContainer',
                [
                    new Reference('epwt_data_provider.types.container')
                ]
            );
        }

        return true;
    }
}
