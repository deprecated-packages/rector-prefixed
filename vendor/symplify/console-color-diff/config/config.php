<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use RectorPrefix2020DecSat\SebastianBergmann\Diff\Differ;
use RectorPrefix2020DecSat\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\ConsoleColorDiff\\', __DIR__ . '/../src');
    $services->set(\RectorPrefix2020DecSat\SebastianBergmann\Diff\Differ::class);
    $services->set(\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\RectorPrefix2020DecSat\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    $services->set(\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
