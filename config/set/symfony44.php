<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Symfony4\Rector\ClassMethod\ConsoleExecuteReturnIntRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.4.md
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://github.com/symfony/symfony/pull/33775
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony4\Rector\ClassMethod\ConsoleExecuteReturnIntRector::class);
};
