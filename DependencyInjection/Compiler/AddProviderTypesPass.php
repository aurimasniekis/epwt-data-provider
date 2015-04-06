<?php

namespace EPWT\Cache\DataProviderBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AddProviderTypesPass
 * @package EPWT\Cache\DataProviderBundle\DependencyInjection\Compiler
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
class AddProviderTypesPass implements CompilerPassInterface
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
        if (!$container->hasDefinition(self::TYPES_CONTAINER_ID)) {
            return false;
        }

        $providerTypesContainer = $container->getDefinition(self::TYPES_CONTAINER_ID);

        $taggedContainers = $container->findTaggedServiceIds('epwt_data_provider.container');

        foreach ($taggedContainers as $id => $tags) {
            $tag = reset($tags);
            $providerType = $tag['type'];
            $definition = $container->getDefinition($id);

            $definition->addMethodCall(
                'setProviderTypesContainer',
                [
                    new Reference(self::TYPES_CONTAINER_ID)
                ]
            );

            $providerTypesContainer->addMethodCall(
                'addProviderType',
                [
                    $providerType,
                    new Reference($id)
                ]
            );

            $containerAlias = self::TYPES_CONTAINER_ID . '.' . $providerType;

            $container->setAlias($containerAlias, $id);
        }

        return true;
    }
}
