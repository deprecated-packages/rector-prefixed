<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

use Rector\Core\Tests\Configuration\Source\CustomLocalRector;
use Rector\Php72\Rector\Assign\ListEachRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Php72\Rector\Assign\ListEachRector::class);
    $services->set(\Rector\Core\Tests\Configuration\Source\CustomLocalRector::class);
};
