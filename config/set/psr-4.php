<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector;
use Rector\PSR4\Rector\Namespace_\MultipleClassFileToPsr4ClassesRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector::class);
    $services->set(\Rector\PSR4\Rector\Namespace_\MultipleClassFileToPsr4ClassesRector::class);
};
