<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScopere8e811afab72\Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector;
use _PhpScopere8e811afab72\Rector\Php80\Rector\Class_\AnnotationToAttributeRector;
use _PhpScopere8e811afab72\Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use _PhpScopere8e811afab72\Rector\Php80\Rector\Class_\StringableForToStringRector;
use _PhpScopere8e811afab72\Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector;
use _PhpScopere8e811afab72\Rector\Php80\Rector\ClassMethod\SetStateToStaticRector;
use _PhpScopere8e811afab72\Rector\Php80\Rector\FuncCall\ClassOnObjectRector;
use _PhpScopere8e811afab72\Rector\Php80\Rector\FuncCall\TokenGetAllToObjectRector;
use _PhpScopere8e811afab72\Rector\Php80\Rector\FunctionLike\UnionTypesRector;
use _PhpScopere8e811afab72\Rector\Php80\Rector\Identical\StrEndsWithRector;
use _PhpScopere8e811afab72\Rector\Php80\Rector\Identical\StrStartsWithRector;
use _PhpScopere8e811afab72\Rector\Php80\Rector\NotIdentical\StrContainsRector;
use _PhpScopere8e811afab72\Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector;
use _PhpScopere8e811afab72\Rector\Php80\Rector\Ternary\GetDebugTypeRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Php80\Rector\FunctionLike\UnionTypesRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php80\Rector\NotIdentical\StrContainsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php80\Rector\Identical\StrStartsWithRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php80\Rector\Identical\StrEndsWithRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php80\Rector\Class_\StringableForToStringRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php80\Rector\Class_\AnnotationToAttributeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php80\Rector\FuncCall\ClassOnObjectRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php80\Rector\Ternary\GetDebugTypeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php80\Rector\FuncCall\TokenGetAllToObjectRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector::class);
    // nette\utils and Strings::replace()
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Nette\\Utils\\Strings', 'replace', 2, 'replacement', '')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php80\Rector\ClassMethod\SetStateToStaticRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector::class);
};
