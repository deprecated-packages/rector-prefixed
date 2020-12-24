<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Neon\NeonPrinter;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\RuleDocGenerator\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/ValueObject']);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Neon\NeonPrinter::class);
    $services->set(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
