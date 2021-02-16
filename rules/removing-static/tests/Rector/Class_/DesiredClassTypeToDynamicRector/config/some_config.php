<?php

declare (strict_types=1);
namespace RectorPrefix20210216;

use Rector\Core\Configuration\Option;
use Rector\RemovingStatic\Rector\Class_\DesiredClassTypeToDynamicRector;
use Rector\RemovingStatic\Tests\Rector\Class_\DesiredClassTypeToDynamicRector\Source\FirstStaticClass;
use RectorPrefix20210216\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210216\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::TYPES_TO_REMOVE_STATIC_FROM, [\Rector\RemovingStatic\Tests\Rector\Class_\DesiredClassTypeToDynamicRector\Source\FirstStaticClass::class]);
    $services = $containerConfigurator->services();
    $services->set(\Rector\RemovingStatic\Rector\Class_\DesiredClassTypeToDynamicRector::class);
};
