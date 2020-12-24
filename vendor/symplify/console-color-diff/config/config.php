<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\SebastianBergmann\Diff\Differ;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\ConsoleColorDiff\\', __DIR__ . '/../src');
    $services->set(\_PhpScoperb75b35f52b74\SebastianBergmann\Diff\Differ::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\service(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
