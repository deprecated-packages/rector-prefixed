<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\Class_\ConstructClassMethodToSetUpTestCaseRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertSameTrueFalseToAssertTrueFalseRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\RemoveExpectAnyFromMockRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\RemoveExpectAnyFromMockRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\Class_\ConstructClassMethodToSetUpTestCaseRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertSameTrueFalseToAssertTrueFalseRector::class);
};
