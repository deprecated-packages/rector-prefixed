<?php

declare (strict_types=1);
namespace RectorPrefix20201228;

use Rector\Nette\Rector\ClassMethod\TemplateMagicAssignToExplicitVariableArrayRector;
use Rector\NetteCodeQuality\Rector\ArrayDimFetch\AnnotateMagicalControlArrayAccessRector;
use Rector\NetteCodeQuality\Rector\Assign\ArrayAccessGetControlToGetComponentMethodCallRector;
use Rector\NetteCodeQuality\Rector\Assign\ArrayAccessSetControlToAddComponentMethodCallRector;
use Rector\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector;
use Rector\NetteCodeQuality\Rector\Identical\SubstrMinusToStringEndsWithRector;
use RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Nette\Rector\ClassMethod\TemplateMagicAssignToExplicitVariableArrayRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\ArrayDimFetch\AnnotateMagicalControlArrayAccessRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\Assign\ArrayAccessSetControlToAddComponentMethodCallRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\Assign\ArrayAccessGetControlToGetComponentMethodCallRector::class);
    $services->set(\Rector\NetteCodeQuality\Rector\Identical\SubstrMinusToStringEndsWithRector::class);
};
