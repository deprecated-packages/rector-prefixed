<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector;
use _PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperb75b35f52b74\\Cake\\Routing\\Exception\\RedirectException' => '_PhpScoperb75b35f52b74\\Cake\\Http\\Exception\\RedirectException', '_PhpScoperb75b35f52b74\\Cake\\Database\\Expression\\Comparison' => '_PhpScoperb75b35f52b74\\Cake\\Database\\Expression\\ComparisonExpression']]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Database\\Schema\\TableSchema', 'getPrimary', 'getPrimaryKey'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Database\\Type\\DateTimeType', 'setTimezone', 'setDatabaseTimezone'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Database\\Expression\\QueryExpression', 'or_', 'or'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Database\\Expression\\QueryExpression', 'and_', 'and'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\View\\Form\\ContextInterface', 'primaryKey', 'getPrimaryKey'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Cake\\Http\\Middleware\\CsrfProtectionMiddleware', 'whitelistCallback', 'skipCheckCallback')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::UNPREFIXED_METHODS_TO_GET_SET => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet('_PhpScoperb75b35f52b74\\Cake\\Form\\Form', 'schema')])]]);
};
