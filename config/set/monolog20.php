<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/Seldaek/monolog/commit/39f8a20e6dadc0194e846b254c5f23d1c732290b#diff-dce565f403e044caa5e6a0d988339430
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Monolog\\Logger', 'addDebug', 'debug'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Monolog\\Logger', 'addInfo', 'info'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Monolog\\Logger', 'addNotice', 'notice'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Monolog\\Logger', 'addWarning', 'warning'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Monolog\\Logger', 'addError', 'error'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Monolog\\Logger', 'addCritical', 'critical'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Monolog\\Logger', 'addAlert', 'alert'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Monolog\\Logger', 'addEmergency', 'emergency'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Monolog\\Logger', 'warn', 'warning'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Monolog\\Logger', 'err', 'error'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Monolog\\Logger', 'crit', 'critical'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Monolog\\Logger', 'emerg', 'emergency')])]]);
};
