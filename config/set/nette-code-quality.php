<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\Nette\Rector\ClassMethod\TemplateMagicAssignToExplicitVariableArrayRector;
use Rector\NetteCodeQuality\Rector\ArrayDimFetch\ChangeControlArrayAccessToAnnotatedControlVariableRector;
use Rector\NetteCodeQuality\Rector\Assign\ArrayAccessGetControlToGetComponentMethodCallRector;
use Rector\NetteCodeQuality\Rector\Assign\ArrayAccessSetControlToAddComponentMethodCallRector;
use Rector\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector;
use Rector\NetteCodeQuality\Rector\Identical\SubstrMinusToStringEndsWithRector;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Nette\Rector\ClassMethod\TemplateMagicAssignToExplicitVariableArrayRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\ArrayDimFetch\ChangeControlArrayAccessToAnnotatedControlVariableRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\Assign\ArrayAccessSetControlToAddComponentMethodCallRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\Assign\ArrayAccessGetControlToGetComponentMethodCallRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\Identical\SubstrMinusToStringEndsWithRector::class);
};
