<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Privatization\Rector\ClassConst\PrivatizeLocalClassConstantRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Privatization\Rector\Property\PrivatizeLocalPropertyToPrivatePropertyRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Privatization\Rector\Property\PrivatizeLocalPropertyToPrivatePropertyRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Privatization\Rector\ClassConst\PrivatizeLocalClassConstantRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector::class);
};
