<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/master/UPGRADE-4.1.md
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        # https://github.com/symfony/symfony/commit/463f986c28a497571967e37c1314e9911f1ef6ba
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Console\\Helper\\TableStyle', 'setHorizontalBorderChar', 'setHorizontalBorderChars'),
        # https://github.com/symfony/symfony/commit/463f986c28a497571967e37c1314e9911f1ef6ba
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Console\\Helper\\TableStyle', 'setVerticalBorderChar', 'setVerticalBorderChars'),
        # https://github.com/symfony/symfony/commit/463f986c28a497571967e37c1314e9911f1ef6ba
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Console\\Helper\\TableStyle', 'setCrossingChar', 'setDefaultCrossingChar'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\HttpFoundation\\File\\UploadedFile', 'getClientSize', 'getSize'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Workflow\\DefinitionBuilder', 'reset', 'clear'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\Workflow\\DefinitionBuilder', 'add', 'addWorkflow'),
        # https://github.com/symfony/symfony/commit/463f986c28a497571967e37c1314e9911f1ef6ba
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey(
            '_PhpScopere8e811afab72\\Symfony\\Component\\Console\\Helper\\TableStyle',
            'getVerticalBorderChar',
            # special case to "getVerticalBorderChar" → "getBorderChars()[3]"
            'getBorderChars',
            3
        ),
        # https://github.com/symfony/symfony/commit/463f986c28a497571967e37c1314e9911f1ef6ba
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey('_PhpScopere8e811afab72\\Symfony\\Component\\Console\\Helper\\TableStyle', 'getHorizontalBorderChar', 'getBorderChars', 2),
    ])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://github.com/symfony/symfony/commit/07dd09db59e2f2a86a291d00d978169d9059e307
        '_PhpScopere8e811afab72\\Symfony\\Bundle\\FrameworkBundle\\DataCollector\\RequestDataCollector' => '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\DataCollector\\RequestDataCollector',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Workflow\\SupportStrategy\\SupportStrategyInterface' => '_PhpScopere8e811afab72\\Symfony\\Component\\Workflow\\SupportStrategy\\WorkflowSupportStrategyInterface',
        '_PhpScopere8e811afab72\\Symfony\\Component\\Workflow\\SupportStrategy\\ClassInstanceSupportStrategy' => '_PhpScopere8e811afab72\\Symfony\\Component\\Workflow\\SupportStrategy\\InstanceOfSupportStrategy',
    ]]]);
};
