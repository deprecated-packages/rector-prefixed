<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector;
use _PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\ModalToGetSet;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper0a2ac50786fa\\Cake\\Routing\\Exception\\RedirectException' => '_PhpScoper0a2ac50786fa\\Cake\\Http\\Exception\\RedirectException', '_PhpScoper0a2ac50786fa\\Cake\\Database\\Expression\\Comparison' => '_PhpScoper0a2ac50786fa\\Cake\\Database\\Expression\\ComparisonExpression']]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Cake\\Database\\Schema\\TableSchema', 'getPrimary', 'getPrimaryKey'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Cake\\Database\\Type\\DateTimeType', 'setTimezone', 'setDatabaseTimezone'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Cake\\Database\\Expression\\QueryExpression', 'or_', 'or'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Cake\\Database\\Expression\\QueryExpression', 'and_', 'and'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Cake\\View\\Form\\ContextInterface', 'primaryKey', 'getPrimaryKey'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Cake\\Http\\Middleware\\CsrfProtectionMiddleware', 'whitelistCallback', 'skipCheckCallback')])]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::UNPREFIXED_METHODS_TO_GET_SET => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoper0a2ac50786fa\\Cake\\Form\\Form', 'schema')])]]);
};
