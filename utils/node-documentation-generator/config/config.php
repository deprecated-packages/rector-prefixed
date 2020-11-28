<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SmartFileSystem\Finder\SmartFinder;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\Utils\\NodeDocumentationGenerator\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject']);
    $services->set(\Symplify\SmartFileSystem\Finder\SmartFinder::class);
};
