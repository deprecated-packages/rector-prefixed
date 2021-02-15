<?php

declare (strict_types=1);
namespace RectorPrefix20210215;

use Rector\Core\ValueObject\FrameworkName;
use Rector\DependencyInjection\Rector\Class_\MultiParentingToAbstractDependencyRector;
use RectorPrefix20210215\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210215\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DependencyInjection\Rector\Class_\MultiParentingToAbstractDependencyRector::class)->call('configure', [[\Rector\DependencyInjection\Rector\Class_\MultiParentingToAbstractDependencyRector::FRAMEWORK => \Rector\Core\ValueObject\FrameworkName::NETTE]]);
};
