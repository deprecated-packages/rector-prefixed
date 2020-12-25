<?php

declare (strict_types=1);
namespace _PhpScoperfce0de0de1ce;

use _PhpScoperfce0de0de1ce\SebastianBergmann\Diff\Differ;
use _PhpScoperfce0de0de1ce\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\ConsoleColorDiff\\', __DIR__ . '/../src');
    $services->set(\_PhpScoperfce0de0de1ce\SebastianBergmann\Diff\Differ::class);
    $services->set(\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\_PhpScoperfce0de0de1ce\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    $services->set(\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
