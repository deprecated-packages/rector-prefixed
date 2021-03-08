<?php

declare (strict_types=1);
namespace RectorPrefix20210308;

use RectorPrefix20210308\SebastianBergmann\Diff\Differ;
use RectorPrefix20210308\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210308\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210308\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use RectorPrefix20210308\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function RectorPrefix20210308\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\RectorPrefix20210308\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('RectorPrefix20210308\Symplify\\ConsoleColorDiff\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Bundle']);
    $services->set(\RectorPrefix20210308\SebastianBergmann\Diff\Differ::class);
    $services->set(\RectorPrefix20210308\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\RectorPrefix20210308\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\RectorPrefix20210308\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20210308\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    $services->set(\RectorPrefix20210308\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
