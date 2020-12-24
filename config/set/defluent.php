<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\ClassMethod\ReturnThisRemoveRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\MethodCall\InArgFluentChainMethodCallToStandaloneMethodCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\MethodCall\MethodCallOnSetterMethodCallToStandaloneAssignRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\MethodCall\NewFluentChainMethodCallToNonFluentRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\Return_\DefluentReturnMethodCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\Return_\ReturnFluentChainMethodCallToNormalMethodCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\Return_\ReturnNewFluentChainMethodCallToNonFluentRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
// @see https://ocramius.github.io/blog/fluent-interfaces-are-evil/
// @see https://www.yegor256.com/2018/03/13/fluent-interfaces.html
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    // variable/property
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\Return_\ReturnFluentChainMethodCallToNormalMethodCallRector::class);
    // new
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\MethodCall\NewFluentChainMethodCallToNonFluentRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\Return_\ReturnNewFluentChainMethodCallToNonFluentRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\ClassMethod\ReturnThisRemoveRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\Return_\DefluentReturnMethodCallRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\MethodCall\MethodCallOnSetterMethodCallToStandaloneAssignRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\MethodCall\InArgFluentChainMethodCallToStandaloneMethodCallRector::class);
};
