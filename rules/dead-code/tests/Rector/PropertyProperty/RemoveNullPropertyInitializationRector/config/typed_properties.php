<?php

declare (strict_types=1);
namespace RectorPrefix20210212;

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector;
use RectorPrefix20210212\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210212\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, \Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES);
    $services = $containerConfigurator->services();
    $services->set(\Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector::class);
};
