<?php

declare (strict_types=1);
namespace RectorPrefix20210421;

use Rector\CodingStyle\Rector\Assign\ManualJsonStringToJsonEncodeArrayRector;
use Rector\CodingStyle\Rector\Assign\PHPStormVarAnnotationRector;
use Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector;
use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector;
use Rector\CodingStyle\Rector\ClassConst\SplitGroupedConstantsAndPropertiesRector;
use Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector;
use Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector;
use Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector;
use Rector\CodingStyle\Rector\ClassMethod\RemoveDoubleUnderscoreInMethodNameRector;
use Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\FuncCall\CallUserFuncCallToVariadicRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector;
use Rector\CodingStyle\Rector\FuncCall\VersionCompareFuncCallToConstantRector;
use Rector\CodingStyle\Rector\If_\NullableCompareToNullRector;
use Rector\CodingStyle\Rector\Include_\FollowRequireByDirRector;
use Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector;
use Rector\CodingStyle\Rector\Plus\UseIncrementAssignRector;
use Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector;
use Rector\CodingStyle\Rector\Property\AddFalseDefaultToBoolPropertyRector;
use Rector\CodingStyle\Rector\String_\SplitStringClassConstantToClassConstFetchRector;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\CodingStyle\Rector\Switch_\BinarySwitchToIfElseRector;
use Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector;
use Rector\CodingStyle\Rector\Use_\RemoveUnusedAliasRector;
use Rector\CodingStyle\Rector\Use_\SplitGroupedUseImportsRector;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Transform\Rector\FuncCall\FuncCallToConstFetchRector;
use RectorPrefix20210421\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210421\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\CodingStyle\Rector\Assign\PHPStormVarAnnotationRector::class);
    $services->set(\Rector\CodingStyle\Rector\If_\NullableCompareToNullRector::class);
    $services->set(\Rector\CodingStyle\Rector\Switch_\BinarySwitchToIfElseRector::class);
    $services->set(\Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector::class);
    $services->set(\Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector::class);
    $services->set(\Rector\CodingStyle\Rector\Use_\RemoveUnusedAliasRector::class);
    $services->set(\Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector::class);
    $services->set(\Rector\CodingStyle\Rector\ClassConst\SplitGroupedConstantsAndPropertiesRector::class);
    $services->set(\Rector\CodingStyle\Rector\String_\SplitStringClassConstantToClassConstFetchRector::class);
    $services->set(\Rector\Php55\Rector\String_\StringClassNameToClassConstantRector::class);
    $services->set(\Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector::class);
    $services->set(\Rector\CodingStyle\Rector\Include_\FollowRequireByDirRector::class);
    $services->set(\Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector::class);
    $services->set(\Rector\CodingStyle\Rector\Plus\UseIncrementAssignRector::class);
    $services->set(\Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector::class);
    $services->set(\Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector::class);
    $services->set(\Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class);
    $services->set(\Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector::class);
    $services->set(\Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector::class);
    $services->set(\Rector\CodingStyle\Rector\Assign\ManualJsonStringToJsonEncodeArrayRector::class);
    $services->set(\Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector::class);
    $services->set(\Rector\CodingStyle\Rector\Property\AddFalseDefaultToBoolPropertyRector::class);
    $services->set(\Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector::class);
    $services->set(\Rector\CodingStyle\Rector\FuncCall\CallUserFuncCallToVariadicRector::class);
    $services->set(\Rector\CodingStyle\Rector\FuncCall\VersionCompareFuncCallToConstantRector::class);
    $services->set(\Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector::class);
    $services->set(\Rector\Transform\Rector\FuncCall\FuncCallToConstFetchRector::class)->call('configure', [[\Rector\Transform\Rector\FuncCall\FuncCallToConstFetchRector::FUNCTIONS_TO_CONSTANTS => ['php_sapi_name' => 'PHP_SAPI', 'pi' => 'M_PI']]]);
    $services->set(\Rector\CodingStyle\Rector\Use_\SplitGroupedUseImportsRector::class);
    $services->set(\Rector\CodingStyle\Rector\ClassMethod\RemoveDoubleUnderscoreInMethodNameRector::class);
    $services->set(\Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector::class);
    $services->set(\Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector::class);
};
