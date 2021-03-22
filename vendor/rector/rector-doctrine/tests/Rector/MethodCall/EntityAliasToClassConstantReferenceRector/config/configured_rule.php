<?php

namespace RectorPrefix20210322;

use Rector\Doctrine\Rector\MethodCall\EntityAliasToClassConstantReferenceRector;
use RectorPrefix20210322\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210322\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../../../../../config/config.php');
    $services = $containerConfigurator->services();
    $services->set(\Rector\Doctrine\Rector\MethodCall\EntityAliasToClassConstantReferenceRector::class)->call('configure', [[\Rector\Doctrine\Rector\MethodCall\EntityAliasToClassConstantReferenceRector::ALIASES_TO_NAMESPACES => ['App' => 'App\\Entity']]]);
};
