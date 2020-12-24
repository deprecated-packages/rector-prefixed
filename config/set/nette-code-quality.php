<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Nette\Rector\ClassMethod\TemplateMagicAssignToExplicitVariableArrayRector;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\ArrayDimFetch\ChangeControlArrayAccessToAnnotatedControlVariableRector;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\Assign\ArrayAccessGetControlToGetComponentMethodCallRector;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\Assign\ArrayAccessSetControlToAddComponentMethodCallRector;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\Identical\SubstrMinusToStringEndsWithRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Nette\Rector\ClassMethod\TemplateMagicAssignToExplicitVariableArrayRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\ArrayDimFetch\ChangeControlArrayAccessToAnnotatedControlVariableRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\Assign\ArrayAccessSetControlToAddComponentMethodCallRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\Assign\ArrayAccessGetControlToGetComponentMethodCallRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\Identical\SubstrMinusToStringEndsWithRector::class);
};
