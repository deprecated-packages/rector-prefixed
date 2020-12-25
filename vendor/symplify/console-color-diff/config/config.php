<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2;

use _PhpScoperf18a0c41e2d2\SebastianBergmann\Diff\Differ;
use _PhpScoperf18a0c41e2d2\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function _PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\ConsoleColorDiff\\', __DIR__ . '/../src');
    $services->set(\_PhpScoperf18a0c41e2d2\SebastianBergmann\Diff\Differ::class);
    $services->set(\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\_PhpScoperf18a0c41e2d2\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\_PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    $services->set(\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
