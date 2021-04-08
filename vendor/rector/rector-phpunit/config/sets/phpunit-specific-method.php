<?php

declare (strict_types=1);
namespace RectorPrefix20210408;

use Rector\PHPUnit\Rector\Foreach_\SimplifyForeachInstanceOfRector;
use Rector\PHPUnit\Rector\MethodCall\AssertCompareToSpecificMethodRector;
use Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector;
use Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector;
use Rector\PHPUnit\Rector\MethodCall\AssertInstanceOfComparisonRector;
use Rector\PHPUnit\Rector\MethodCall\AssertIssetToSpecificMethodRector;
use Rector\PHPUnit\Rector\MethodCall\AssertNotOperatorRector;
use Rector\PHPUnit\Rector\MethodCall\AssertPropertyExistsRector;
use Rector\PHPUnit\Rector\MethodCall\AssertRegExpRector;
use Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector;
use Rector\PHPUnit\Rector\MethodCall\AssertTrueFalseInternalTypeToSpecificMethodRector;
use Rector\PHPUnit\Rector\MethodCall\AssertTrueFalseToSpecificMethodRector;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\PHPUnit\Rector\MethodCall\AssertNotOperatorRector::class);
    $services->set(\Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector::class);
    $services->set(\Rector\PHPUnit\Rector\MethodCall\AssertTrueFalseToSpecificMethodRector::class);
    $services->set(\Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector::class);
    $services->set(\Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector::class);
    $services->set(\Rector\PHPUnit\Rector\MethodCall\AssertTrueFalseInternalTypeToSpecificMethodRector::class);
    $services->set(\Rector\PHPUnit\Rector\MethodCall\AssertCompareToSpecificMethodRector::class);
    $services->set(\Rector\PHPUnit\Rector\MethodCall\AssertIssetToSpecificMethodRector::class);
    $services->set(\Rector\PHPUnit\Rector\MethodCall\AssertInstanceOfComparisonRector::class);
    $services->set(\Rector\PHPUnit\Rector\MethodCall\AssertPropertyExistsRector::class);
    $services->set(\Rector\PHPUnit\Rector\MethodCall\AssertRegExpRector::class);
    $services->set(\Rector\PHPUnit\Rector\Foreach_\SimplifyForeachInstanceOfRector::class);
};
