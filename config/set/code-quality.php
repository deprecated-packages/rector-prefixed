<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Array_\ArrayThisCallToThisMethodCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Assign\CombinedAssignRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Assign\SplitListAssignToSeparateLineRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\BooleanNot\SimplifyDeMorganBinaryRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\ClassMethod\DateTimeToDateTimeInterfaceRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Concat\JoinStringConcatRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Expression\InlineIfToExplicitIfRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\For_\ForRepeatedCountToOwnVariableRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\For_\ForToForeachRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Foreach_\ForeachToInArrayRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToArrayFilterRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToCoalescingRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\AddPregQuoteDelimiterRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\ArrayKeysAndInArrayToArrayKeyExistsRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\ArrayMergeOfNonArraysToSimpleArrayRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\ChangeArrayPushToArrayAssignRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\InArrayAndArrayKeysToArrayKeyExistsRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\IntvalToTypeCastRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\IsAWithStringWithThirdArgumentRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\RemoveSoleValueSprintfRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\SetTypeToCastRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\SimplifyFuncGetArgsCountRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\SimplifyInArrayValuesRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\SimplifyRegexPatternRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\SimplifyStrposLowerRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\SingleInArrayToCompareRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\UnwrapSprintfOneArgumentRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FunctionLike\RemoveAlwaysTrueConditionSetInConstructorRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Identical\BooleanNotIdenticalToNotIdenticalRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Identical\GetClassToInstanceOfRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Identical\SimplifyArraySearchRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Identical\SimplifyConditionsRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Identical\StrlenZeroToIdenticalEmptyStringRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\CombineIfRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\ShortenElseIfRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\SimplifyIfIssetToNullCoalescingRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\SimplifyIfNotNullReturnRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\LogicalAnd\AndAssignsToSeparateLinesRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Name\FixClassCaseSensitivityNameRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\New_\NewStaticToNewSelfRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\NotEqual\CommonNotEqualRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Return_\SimplifyUselessVariableRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Ternary\ArrayKeyExistsTernaryThenValueToCoalescingRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Ternary\SimplifyDuplicatedTernaryRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Ternary\SimplifyTautologyTernaryRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Ternary\UnnecessaryTernaryExpressionRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php52\Rector\Property\VarToPublicPropertyRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Assign\CombinedAssignRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Foreach_\ForeachToInArrayRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToCoalescingRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\InArrayAndArrayKeysToArrayKeyExistsRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\SimplifyFuncGetArgsCountRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\SimplifyInArrayValuesRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\SimplifyStrposLowerRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Identical\GetClassToInstanceOfRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Identical\SimplifyArraySearchRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Identical\SimplifyConditionsRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\SimplifyIfNotNullReturnRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Return_\SimplifyUselessVariableRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Ternary\UnnecessaryTernaryExpressionRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\BooleanNot\SimplifyDeMorganBinaryRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Ternary\SimplifyTautologyTernaryRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToArrayFilterRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\SingleInArrayToCompareRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Concat\JoinStringConcatRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\SimplifyIfIssetToNullCoalescingRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\CombineIfRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Ternary\SimplifyDuplicatedTernaryRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\SimplifyRegexPatternRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Identical\BooleanNotIdenticalToNotIdenticalRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\LogicalAnd\AndAssignsToSeparateLinesRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\For_\ForToForeachRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\IsAWithStringWithThirdArgumentRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Identical\StrlenZeroToIdenticalEmptyStringRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FunctionLike\RemoveAlwaysTrueConditionSetInConstructorRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\RemoveSoleValueSprintfRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\If_\ShortenElseIfRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\SOLID\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\AddPregQuoteDelimiterRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\ArrayMergeOfNonArraysToSimpleArrayRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\IntvalToTypeCastRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Ternary\ArrayKeyExistsTernaryThenValueToCoalescingRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\ChangeArrayPushToArrayAssignRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\For_\ForRepeatedCountToOwnVariableRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Expression\InlineIfToExplicitIfRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\ArrayKeysAndInArrayToArrayKeyExistsRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Assign\SplitListAssignToSeparateLineRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Array_\ArrayThisCallToThisMethodCallRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\NotEqual\CommonNotEqualRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::OLD_FUNCTION_TO_NEW_FUNCTION => [
        'split' => 'explode',
        'join' => 'implode',
        'sizeof' => 'count',
        # https://www.php.net/manual/en/aliases.php
        'chop' => 'rtrim',
        'doubleval' => 'floatval',
        'gzputs' => 'gzwrites',
        'fputs' => 'fwrite',
        'ini_alter' => 'ini_set',
        'is_double' => 'is_float',
        'is_integer' => 'is_int',
        'is_long' => 'is_int',
        'is_real' => 'is_float',
        'is_writeable' => 'is_writable',
        'key_exists' => 'array_key_exists',
        'pos' => 'current',
        'strchr' => 'strstr',
        # mb
        'mbstrcut' => 'mb_strcut',
        'mbstrlen' => 'mb_strlen',
        'mbstrpos' => 'mb_strpos',
        'mbstrrpos' => 'mb_strrpos',
        'mbsubstr' => 'mb_substr',
    ]]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\SetTypeToCastRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php52\Rector\Property\VarToPublicPropertyRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Name\FixClassCaseSensitivityNameRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\New_\NewStaticToNewSelfRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\ClassMethod\DateTimeToDateTimeInterfaceRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\FuncCall\UnwrapSprintfOneArgumentRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector::class);
};
