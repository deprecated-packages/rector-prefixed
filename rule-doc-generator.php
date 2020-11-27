<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

use Rector\RuleDocGenerator\Category\RectorCategoryInferer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire();
    $services->set(\Rector\RuleDocGenerator\Category\RectorCategoryInferer::class);
};
