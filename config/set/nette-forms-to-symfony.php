<?php

declare (strict_types=1);
namespace RectorPrefix20210329;

use Rector\NetteToSymfony\Rector\MethodCall\NetteFormToSymfonyFormRector;
use RectorPrefix20210329\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210329\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\NetteToSymfony\Rector\MethodCall\NetteFormToSymfonyFormRector::class);
};
