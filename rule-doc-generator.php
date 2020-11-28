<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use Rector\RuleDocGenerator\Category\RectorCategoryInferer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire();
    $services->set(\Rector\RuleDocGenerator\Category\RectorCategoryInferer::class);
};
