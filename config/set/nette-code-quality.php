<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739;

use Rector\Nette\Rector\ClassMethod\TemplateMagicAssignToExplicitVariableArrayRector;
use Rector\NetteCodeQuality\Rector\ArrayDimFetch\ChangeControlArrayAccessToAnnotatedControlVariableRector;
use Rector\NetteCodeQuality\Rector\Assign\ArrayAccessGetControlToGetComponentMethodCallRector;
use Rector\NetteCodeQuality\Rector\Assign\ArrayAccessSetControlToAddComponentMethodCallRector;
use Rector\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector;
use Rector\NetteCodeQuality\Rector\Identical\SubstrMinusToStringEndsWithRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Nette\Rector\ClassMethod\TemplateMagicAssignToExplicitVariableArrayRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\ArrayDimFetch\ChangeControlArrayAccessToAnnotatedControlVariableRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\Assign\ArrayAccessSetControlToAddComponentMethodCallRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\Assign\ArrayAccessGetControlToGetComponentMethodCallRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\Identical\SubstrMinusToStringEndsWithRector::class);
};
