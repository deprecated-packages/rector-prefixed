<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/Seldaek/monolog/commit/39f8a20e6dadc0194e846b254c5f23d1c732290b#diff-dce565f403e044caa5e6a0d988339430
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Monolog\\Logger', 'addDebug', 'debug'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Monolog\\Logger', 'addInfo', 'info'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Monolog\\Logger', 'addNotice', 'notice'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Monolog\\Logger', 'addWarning', 'warning'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Monolog\\Logger', 'addError', 'error'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Monolog\\Logger', 'addCritical', 'critical'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Monolog\\Logger', 'addAlert', 'alert'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Monolog\\Logger', 'addEmergency', 'emergency'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Monolog\\Logger', 'warn', 'warning'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Monolog\\Logger', 'err', 'error'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Monolog\\Logger', 'crit', 'critical'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Monolog\\Logger', 'emerg', 'emergency')])]]);
};
