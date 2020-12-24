<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\ClassMethod\ExceptionAnnotationRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\DelegateExceptionArgumentsRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # handles 2nd and 3rd argument of setExpectedException
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\DelegateExceptionArgumentsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\ClassMethod\ExceptionAnnotationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestClass', 'setExpectedException', 'expectedException'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestClass', 'setExpectedExceptionRegExp', 'expectedException')])]]);
};
