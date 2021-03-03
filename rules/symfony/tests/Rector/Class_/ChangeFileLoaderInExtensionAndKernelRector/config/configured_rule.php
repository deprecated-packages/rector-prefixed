<?php

declare (strict_types=1);
namespace RectorPrefix20210303;

use Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector;
use RectorPrefix20210303\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210303\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector::class)->call('configure', [[\Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector::FROM => 'xml', \Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector::TO => 'yaml']]);
};
