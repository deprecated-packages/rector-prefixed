<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\SebastianBergmann\Diff\Differ;
use _PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\ConsoleColorDiff\\', __DIR__ . '/../src');
    $services->set(\_PhpScopere8e811afab72\SebastianBergmann\Diff\Differ::class);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\_PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    $services->set(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
