<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Privatization\Rector\ClassConst\PrivatizeLocalClassConstantRector;
use _PhpScoper0a6b37af0871\Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector;
use _PhpScoper0a6b37af0871\Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector;
use _PhpScoper0a6b37af0871\Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector;
use _PhpScoper0a6b37af0871\Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector;
use _PhpScoper0a6b37af0871\Rector\Privatization\Rector\Property\PrivatizeLocalPropertyToPrivatePropertyRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Privatization\Rector\Property\PrivatizeLocalPropertyToPrivatePropertyRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Privatization\Rector\ClassConst\PrivatizeLocalClassConstantRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector::class);
};
