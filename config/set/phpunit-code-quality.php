<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\Class_\ConstructClassMethodToSetUpTestCaseRector;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\MethodCall\AssertSameTrueFalseToAssertTrueFalseRector;
use _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\MethodCall\RemoveExpectAnyFromMockRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\MethodCall\RemoveExpectAnyFromMockRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\Class_\ConstructClassMethodToSetUpTestCaseRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\MethodCall\AssertSameTrueFalseToAssertTrueFalseRector::class);
};
