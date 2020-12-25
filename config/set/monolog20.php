<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/Seldaek/monolog/commit/39f8a20e6dadc0194e846b254c5f23d1c732290b#diff-dce565f403e044caa5e6a0d988339430
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Monolog\\Logger', 'addDebug', 'debug'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Monolog\\Logger', 'addInfo', 'info'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Monolog\\Logger', 'addNotice', 'notice'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Monolog\\Logger', 'addWarning', 'warning'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Monolog\\Logger', 'addError', 'error'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Monolog\\Logger', 'addCritical', 'critical'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Monolog\\Logger', 'addAlert', 'alert'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Monolog\\Logger', 'addEmergency', 'emergency'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Monolog\\Logger', 'warn', 'warning'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Monolog\\Logger', 'err', 'error'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Monolog\\Logger', 'crit', 'critical'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Monolog\\Logger', 'emerg', 'emergency')])]]);
};
