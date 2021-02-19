<?php

namespace RectorPrefix20210219;

use Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector;
use Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector;
use Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector;
use RectorPrefix20210219\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210219\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector::class);
    $services->set(\Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector::class);
    $services->set(\Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector::class);
};
