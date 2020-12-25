<?php

declare (strict_types=1);
namespace _PhpScoper17db12703726;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# source: https://book.cakephp.org/4/en/appendices/4-2-migration-guide.html
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper17db12703726\\Cake\\Core\\Exception\\Exception' => '_PhpScoper17db12703726\\Cake\\Core\\Exception\\CakeException', '_PhpScoper17db12703726\\Cake\\Database\\Exception' => '_PhpScoper17db12703726\\Cake\\Database\\Exception\\DatabaseException']]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper17db12703726\\Cake\\ORM\\Behavior', 'getTable', 'table')])]]);
};
