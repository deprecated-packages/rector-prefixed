<?php

declare (strict_types=1);
namespace RectorPrefix20210417;

use Rector\NetteToSymfony\Rector\MethodCall\NetteFormToSymfonyFormRector;
use RectorPrefix20210417\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210417\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\NetteToSymfony\Rector\MethodCall\NetteFormToSymfonyFormRector::class);
};
