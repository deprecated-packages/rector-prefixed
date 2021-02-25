<?php

declare (strict_types=1);
namespace RectorPrefix20210225;

use Rector\Symfony4\Rector\ClassMethod\ConsoleExecuteReturnIntRector;
use RectorPrefix20210225\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.4.md
return static function (\RectorPrefix20210225\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://github.com/symfony/symfony/pull/33775
    $services->set(\Rector\Symfony4\Rector\ClassMethod\ConsoleExecuteReturnIntRector::class);
};
