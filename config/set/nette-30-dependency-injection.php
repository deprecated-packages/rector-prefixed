<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Nette\Rector\MethodCall\BuilderExpandToHelperExpandRector;
use _PhpScopere8e811afab72\Rector\Nette\Rector\MethodCall\SetClassWithArgumentToSetFactoryRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Nette\Rector\MethodCall\SetClassWithArgumentToSetFactoryRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Nette\Rector\MethodCall\BuilderExpandToHelperExpandRector::class);
};
