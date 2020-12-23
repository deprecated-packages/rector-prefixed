<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\Foreach_\SimplifyForeachInstanceOfRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertCompareToSpecificMethodRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertInstanceOfComparisonRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertIssetToSpecificMethodRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertNotOperatorRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertPropertyExistsRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertRegExpRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertTrueFalseInternalTypeToSpecificMethodRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertTrueFalseToSpecificMethodRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertNotOperatorRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertTrueFalseToSpecificMethodRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertTrueFalseInternalTypeToSpecificMethodRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertCompareToSpecificMethodRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertIssetToSpecificMethodRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertInstanceOfComparisonRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertPropertyExistsRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall\AssertRegExpRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\Foreach_\SimplifyForeachInstanceOfRector::class);
};
