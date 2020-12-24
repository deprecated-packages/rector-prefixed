<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/symfony/symfony/blob/master/UPGRADE-4.1.md
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        # https://github.com/symfony/symfony/commit/463f986c28a497571967e37c1314e9911f1ef6ba
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Console\\Helper\\TableStyle', 'setHorizontalBorderChar', 'setHorizontalBorderChars'),
        # https://github.com/symfony/symfony/commit/463f986c28a497571967e37c1314e9911f1ef6ba
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Console\\Helper\\TableStyle', 'setVerticalBorderChar', 'setVerticalBorderChars'),
        # https://github.com/symfony/symfony/commit/463f986c28a497571967e37c1314e9911f1ef6ba
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Console\\Helper\\TableStyle', 'setCrossingChar', 'setDefaultCrossingChar'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpFoundation\\File\\UploadedFile', 'getClientSize', 'getSize'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Workflow\\DefinitionBuilder', 'reset', 'clear'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Symfony\\Component\\Workflow\\DefinitionBuilder', 'add', 'addWorkflow'),
        # https://github.com/symfony/symfony/commit/463f986c28a497571967e37c1314e9911f1ef6ba
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey(
            '_PhpScoperb75b35f52b74\\Symfony\\Component\\Console\\Helper\\TableStyle',
            'getVerticalBorderChar',
            # special case to "getVerticalBorderChar" → "getBorderChars()[3]"
            'getBorderChars',
            3
        ),
        # https://github.com/symfony/symfony/commit/463f986c28a497571967e37c1314e9911f1ef6ba
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey('_PhpScoperb75b35f52b74\\Symfony\\Component\\Console\\Helper\\TableStyle', 'getHorizontalBorderChar', 'getBorderChars', 2),
    ])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # https://github.com/symfony/symfony/commit/07dd09db59e2f2a86a291d00d978169d9059e307
        '_PhpScoperb75b35f52b74\\Symfony\\Bundle\\FrameworkBundle\\DataCollector\\RequestDataCollector' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\HttpKernel\\DataCollector\\RequestDataCollector',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Workflow\\SupportStrategy\\SupportStrategyInterface' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Workflow\\SupportStrategy\\WorkflowSupportStrategyInterface',
        '_PhpScoperb75b35f52b74\\Symfony\\Component\\Workflow\\SupportStrategy\\ClassInstanceSupportStrategy' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Workflow\\SupportStrategy\\InstanceOfSupportStrategy',
    ]]]);
};
