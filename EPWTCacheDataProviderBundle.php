<?php

namespace EPWT\Cache\DataProviderBundle;

use EPWT\Cache\DataProviderBundle\DependencyInjection\Compiler\AddProvidersPass;
use EPWT\Cache\DataProviderBundle\DependencyInjection\Compiler\AddProviderTypesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EPWTCacheDataProviderBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddProviderTypesPass());
        $container->addCompilerPass(new AddProvidersPass());
    }
}
