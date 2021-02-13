<?php

declare (strict_types=1);
namespace RectorPrefix20210213;

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\Php71\Rector\FuncCall\CountOnNullRector;
use RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, \Rector\Core\ValueObject\PhpVersionFeature::COUNT_ON_NULL);
    $services = $containerConfigurator->services();
    $services->set(\Rector\Php71\Rector\FuncCall\CountOnNullRector::class);
};
