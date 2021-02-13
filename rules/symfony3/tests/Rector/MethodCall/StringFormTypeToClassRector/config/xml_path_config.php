<?php

declare (strict_types=1);
namespace RectorPrefix20210213;

use Rector\Core\Configuration\Option;
use Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector;
use RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER, __DIR__ . '/../Source/custom_container.xml');
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector::class);
};
