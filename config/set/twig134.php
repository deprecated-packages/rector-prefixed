<?php

declare (strict_types=1);
namespace _PhpScoper17db12703726;

use Rector\Twig\Rector\Return_\SimpleFunctionAndFilterRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Twig\Rector\Return_\SimpleFunctionAndFilterRector::class);
};
