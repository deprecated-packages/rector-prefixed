<?php

declare (strict_types=1);
namespace RectorPrefix20210503;

use Rector\Privatization\Rector\Class_\ChangeLocalPropertyToVariableRector;
use Rector\Privatization\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector;
use Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector;
use Rector\Privatization\Rector\Class_\RepeatedLiteralToClassConstantRector;
use Rector\Privatization\Rector\ClassMethod\ChangeGlobalVariablesToPropertiesRector;
use Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector;
use Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector;
use Rector\Privatization\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector;
use Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector;
use Rector\Privatization\Rector\Property\PrivatizeLocalPropertyToPrivatePropertyRector;
use RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector::class);
    $services->set(\Rector\Privatization\Rector\ClassMethod\ChangeGlobalVariablesToPropertiesRector::class);
    $services->set(\Rector\Privatization\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector::class);
    $services->set(\Rector\Privatization\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector::class);
    $services->set(\Rector\Privatization\Rector\Class_\RepeatedLiteralToClassConstantRector::class);
    $services->set(\Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector::class);
    $services->set(\Rector\Privatization\Rector\Property\PrivatizeLocalPropertyToPrivatePropertyRector::class);
    $services->set(\Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector::class);
    $services->set(\Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector::class);
    // buggy, requires more work
    // $services->set(ChangeLocalPropertyToVariableRector::class);
};
