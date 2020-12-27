<?php

declare (strict_types=1);
namespace RectorPrefix20201227;

use RectorPrefix20201227\SebastianBergmann\Diff\Differ;
use RectorPrefix20201227\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20201227\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use RectorPrefix20201227\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\ConsoleColorDiff\\', __DIR__ . '/../src');
    $services->set(\RectorPrefix20201227\SebastianBergmann\Diff\Differ::class);
    $services->set(\RectorPrefix20201227\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\RectorPrefix20201227\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20201227\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    $services->set(\RectorPrefix20201227\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
