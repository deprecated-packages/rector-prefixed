<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\Class_\ConstructClassMethodToSetUpTestCaseRector;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall\AssertSameTrueFalseToAssertTrueFalseRector;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall\RemoveExpectAnyFromMockRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall\RemoveExpectAnyFromMockRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\Class_\ConstructClassMethodToSetUpTestCaseRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall\AssertSameTrueFalseToAssertTrueFalseRector::class);
};
