<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\SebastianBergmann\Diff\Differ;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\ConsoleColorDiff\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper0a2ac50786fa\SebastianBergmann\Diff\Differ::class);
    $services->set(\_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\_PhpScoper0a2ac50786fa\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    $services->set(\_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
