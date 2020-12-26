<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/Seldaek/monolog/commit/39f8a20e6dadc0194e846b254c5f23d1c732290b#diff-dce565f403e044caa5e6a0d988339430
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Monolog\\Logger', 'addDebug', 'debug'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Monolog\\Logger', 'addInfo', 'info'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Monolog\\Logger', 'addNotice', 'notice'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Monolog\\Logger', 'addWarning', 'warning'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Monolog\\Logger', 'addError', 'error'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Monolog\\Logger', 'addCritical', 'critical'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Monolog\\Logger', 'addAlert', 'alert'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Monolog\\Logger', 'addEmergency', 'emergency'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Monolog\\Logger', 'warn', 'warning'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Monolog\\Logger', 'err', 'error'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Monolog\\Logger', 'crit', 'critical'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Monolog\\Logger', 'emerg', 'emergency')])]]);
};
