<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\Class_\ConstructClassMethodToSetUpTestCaseRector;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\AssertSameTrueFalseToAssertTrueFalseRector;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\RemoveExpectAnyFromMockRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\RemoveExpectAnyFromMockRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\Class_\ConstructClassMethodToSetUpTestCaseRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall\AssertSameTrueFalseToAssertTrueFalseRector::class);
};
