<?php

declare (strict_types=1);
namespace RectorPrefix20210408;

use Rector\Nette\Rector\MethodCall\BuilderExpandToHelperExpandRector;
use Rector\Nette\Rector\MethodCall\SetClassWithArgumentToSetFactoryRector;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Nette\Rector\MethodCall\SetClassWithArgumentToSetFactoryRector::class);
    $services->set(\Rector\Nette\Rector\MethodCall\BuilderExpandToHelperExpandRector::class);
};
