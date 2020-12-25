<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2;

use Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector;
use Rector\CakePHP\ValueObject\ModalToGetSet;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperf18a0c41e2d2\\Cake\\Routing\\Exception\\RedirectException' => '_PhpScoperf18a0c41e2d2\\Cake\\Http\\Exception\\RedirectException', '_PhpScoperf18a0c41e2d2\\Cake\\Database\\Expression\\Comparison' => '_PhpScoperf18a0c41e2d2\\Cake\\Database\\Expression\\ComparisonExpression']]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperf18a0c41e2d2\\Cake\\Database\\Schema\\TableSchema', 'getPrimary', 'getPrimaryKey'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperf18a0c41e2d2\\Cake\\Database\\Type\\DateTimeType', 'setTimezone', 'setDatabaseTimezone'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperf18a0c41e2d2\\Cake\\Database\\Expression\\QueryExpression', 'or_', 'or'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperf18a0c41e2d2\\Cake\\Database\\Expression\\QueryExpression', 'and_', 'and'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperf18a0c41e2d2\\Cake\\View\\Form\\ContextInterface', 'primaryKey', 'getPrimaryKey'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperf18a0c41e2d2\\Cake\\Http\\Middleware\\CsrfProtectionMiddleware', 'whitelistCallback', 'skipCheckCallback')])]]);
    $services->set(\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::class)->call('configure', [[\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::UNPREFIXED_METHODS_TO_GET_SET => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperf18a0c41e2d2\\Cake\\Form\\Form', 'schema')])]]);
};
