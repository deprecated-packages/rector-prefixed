<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\Class_\AnnotationToAttributeRector;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\Class_\StringableForToStringRector;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\ClassMethod\SetStateToStaticRector;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\FuncCall\ClassOnObjectRector;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\FuncCall\TokenGetAllToObjectRector;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\FunctionLike\UnionTypesRector;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\Identical\StrEndsWithRector;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\Identical\StrStartsWithRector;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\NotIdentical\StrContainsRector;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\Ternary\GetDebugTypeRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php80\Rector\FunctionLike\UnionTypesRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php80\Rector\NotIdentical\StrContainsRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php80\Rector\Identical\StrStartsWithRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php80\Rector\Identical\StrEndsWithRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php80\Rector\Class_\StringableForToStringRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php80\Rector\Class_\AnnotationToAttributeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php80\Rector\FuncCall\ClassOnObjectRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php80\Rector\Ternary\GetDebugTypeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php80\Rector\FuncCall\TokenGetAllToObjectRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector::class);
    // nette\utils and Strings::replace()
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Nette\\Utils\\Strings', 'replace', 2, 'replacement', '')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php80\Rector\ClassMethod\SetStateToStaticRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector::class);
};
