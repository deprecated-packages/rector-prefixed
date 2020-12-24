<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\Foreach_\SimplifyForeachInstanceOfRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertCompareToSpecificMethodRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertInstanceOfComparisonRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertIssetToSpecificMethodRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertNotOperatorRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertPropertyExistsRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertRegExpRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertTrueFalseInternalTypeToSpecificMethodRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertTrueFalseToSpecificMethodRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertNotOperatorRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertTrueFalseToSpecificMethodRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertTrueFalseInternalTypeToSpecificMethodRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertCompareToSpecificMethodRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertIssetToSpecificMethodRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertInstanceOfComparisonRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertPropertyExistsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertRegExpRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\Foreach_\SimplifyForeachInstanceOfRector::class);
};
