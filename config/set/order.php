<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderClassConstantsByIntegerValueRector;
use _PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderConstantsByVisibilityRector;
use _PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderMethodsByVisibilityRector;
use _PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderPrivateMethodsByUseRector;
use _PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderPropertiesByVisibilityRector;
use _PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderPropertyByComplexityRector;
use _PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector;
use _PhpScoperb75b35f52b74\Rector\Order\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderPrivateMethodsByUseRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderPropertyByComplexityRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderClassConstantsByIntegerValueRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Order\Rector\ClassMethod\OrderConstructorDependenciesByTypeAlphabeticallyRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderMethodsByVisibilityRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderPropertiesByVisibilityRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderConstantsByVisibilityRector::class);
};
