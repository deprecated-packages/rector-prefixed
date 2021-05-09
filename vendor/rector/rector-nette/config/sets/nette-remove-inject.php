<?php

declare (strict_types=1);
namespace RectorPrefix20210509;

use Rector\Nette\Rector\Property\NetteInjectToConstructorInjectionRector;
use RectorPrefix20210509\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210509\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Nette\Rector\Property\NetteInjectToConstructorInjectionRector::class);
};
