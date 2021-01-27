<?php

declare (strict_types=1);
namespace RectorPrefix20210127;

use Rector\Core\Configuration\Option;
use Rector\RemovingStatic\Rector\Property\DesiredPropertyClassMethodTypeToDynamicRector;
use Rector\RemovingStatic\Tests\Rector\Property\DesiredPropertyClassMethodTypeToDynamicRector\Fixture\StaticProperty;
use RectorPrefix20210127\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210127\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::TYPES_TO_REMOVE_STATIC_FROM, [\Rector\RemovingStatic\Tests\Rector\Property\DesiredPropertyClassMethodTypeToDynamicRector\Fixture\StaticProperty::class]);
    $services = $containerConfigurator->services();
    $services->set(\Rector\RemovingStatic\Rector\Property\DesiredPropertyClassMethodTypeToDynamicRector::class);
};
