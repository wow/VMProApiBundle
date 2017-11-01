<?php

namespace MovingImage\Bundle\VMProApiBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class StopwatchPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $clientDefinition = $container->getDefinition('vmpro_api.client');

        if ($container->getParameter('vm_pro_api_enable_stopwatch')) {
            $clientDefinition->setArgument(5, new Reference('vmpro_api.stopwatch'));
        }
    }
}
