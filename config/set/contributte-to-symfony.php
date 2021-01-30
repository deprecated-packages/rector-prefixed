<?php

declare (strict_types=1);
namespace RectorPrefix20210130;

use Rector\NetteToSymfony\Rector\ClassMethod\RenameEventNamesInEventSubscriberRector;
use RectorPrefix20210130\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210130\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\NetteToSymfony\Rector\ClassMethod\RenameEventNamesInEventSubscriberRector::class);
};
