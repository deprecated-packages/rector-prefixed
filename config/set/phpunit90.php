<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\Class_\TestListenerToHooksRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\ExplicitPhpErrorApiRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\SpecificAssertContainsWithoutIdentityRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\Class_\TestListenerToHooksRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\ExplicitPhpErrorApiRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\SpecificAssertContainsWithoutIdentityRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[
        // see https://github.com/sebastianbergmann/phpunit/issues/3957
        \_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'expectExceptionMessageRegExp', 'expectExceptionMessageMatches'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'assertRegExp', 'assertMatchesRegularExpression')]),
    ]]);
};
