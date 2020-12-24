<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScoper0a6b37af0871\Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector;
use _PhpScoper0a6b37af0871\Rector\Php80\Rector\Class_\AnnotationToAttributeRector;
use _PhpScoper0a6b37af0871\Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use _PhpScoper0a6b37af0871\Rector\Php80\Rector\Class_\StringableForToStringRector;
use _PhpScoper0a6b37af0871\Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector;
use _PhpScoper0a6b37af0871\Rector\Php80\Rector\ClassMethod\SetStateToStaticRector;
use _PhpScoper0a6b37af0871\Rector\Php80\Rector\FuncCall\ClassOnObjectRector;
use _PhpScoper0a6b37af0871\Rector\Php80\Rector\FuncCall\TokenGetAllToObjectRector;
use _PhpScoper0a6b37af0871\Rector\Php80\Rector\FunctionLike\UnionTypesRector;
use _PhpScoper0a6b37af0871\Rector\Php80\Rector\Identical\StrEndsWithRector;
use _PhpScoper0a6b37af0871\Rector\Php80\Rector\Identical\StrStartsWithRector;
use _PhpScoper0a6b37af0871\Rector\Php80\Rector\NotIdentical\StrContainsRector;
use _PhpScoper0a6b37af0871\Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector;
use _PhpScoper0a6b37af0871\Rector\Php80\Rector\Ternary\GetDebugTypeRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php80\Rector\FunctionLike\UnionTypesRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php80\Rector\NotIdentical\StrContainsRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php80\Rector\Identical\StrStartsWithRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php80\Rector\Identical\StrEndsWithRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php80\Rector\Class_\StringableForToStringRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php80\Rector\Class_\AnnotationToAttributeRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php80\Rector\FuncCall\ClassOnObjectRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php80\Rector\Ternary\GetDebugTypeRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php80\Rector\FuncCall\TokenGetAllToObjectRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector::class);
    // nette\utils and Strings::replace()
    $services->set(\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper0a6b37af0871\\Nette\\Utils\\Strings', 'replace', 2, 'replacement', '')])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php80\Rector\ClassMethod\SetStateToStaticRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector::class);
};
