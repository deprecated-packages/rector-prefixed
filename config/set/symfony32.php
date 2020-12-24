<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Symfony\\Component\\DependencyInjection\\ContainerBuilder', 'addCompilerPass', 2, 'priority', '0')])]]);
};
