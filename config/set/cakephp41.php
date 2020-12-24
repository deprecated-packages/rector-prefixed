<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector;
use _PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScopere8e811afab72\\Cake\\Routing\\Exception\\RedirectException' => '_PhpScopere8e811afab72\\Cake\\Http\\Exception\\RedirectException', '_PhpScopere8e811afab72\\Cake\\Database\\Expression\\Comparison' => '_PhpScopere8e811afab72\\Cake\\Database\\Expression\\ComparisonExpression']]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Database\\Schema\\TableSchema', 'getPrimary', 'getPrimaryKey'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Database\\Type\\DateTimeType', 'setTimezone', 'setDatabaseTimezone'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Database\\Expression\\QueryExpression', 'or_', 'or'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Database\\Expression\\QueryExpression', 'and_', 'and'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\View\\Form\\ContextInterface', 'primaryKey', 'getPrimaryKey'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Cake\\Http\\Middleware\\CsrfProtectionMiddleware', 'whitelistCallback', 'skipCheckCallback')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::UNPREFIXED_METHODS_TO_GET_SET => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScopere8e811afab72\\Cake\\Form\\Form', 'schema')])]]);
};
