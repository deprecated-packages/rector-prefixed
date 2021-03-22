<?php

declare (strict_types=1);
namespace RectorPrefix20210322;

use RectorPrefix20210322\Symfony\Component\Console\Application;
use RectorPrefix20210322\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210322\Symplify\ConsolePackageBuilder\Tests\DependencyInjection\CompilerPass\Source\SomeCommand;
use function RectorPrefix20210322\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\RectorPrefix20210322\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->set(\RectorPrefix20210322\Symplify\ConsolePackageBuilder\Tests\DependencyInjection\CompilerPass\Source\SomeCommand::class);
    $services->set(\RectorPrefix20210322\Symfony\Component\Console\Application::class)->call('add', [\RectorPrefix20210322\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20210322\Symplify\ConsolePackageBuilder\Tests\DependencyInjection\CompilerPass\Source\SomeCommand::class)]);
};