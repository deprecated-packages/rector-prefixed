<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Generators;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\YieldFrom;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper;
use _PhpScopere8e811afab72\PHPStan\Type\GenericTypeVariableResolver;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
use _PhpScopere8e811afab72\PHPStan\Type\VoidType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\YieldFrom>
 */
class YieldFromTypeRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var bool */
    private $reportMaybes;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, bool $reportMaybes)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->reportMaybes = $reportMaybes;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\YieldFrom::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $exprType = $scope->getType($node->expr);
        $isIterable = $exprType->isIterable();
        $messagePattern = 'Argument of an invalid type %s passed to yield from, only iterables are supported.';
        if ($isIterable->no()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, $exprType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->line($node->expr->getLine())->build()];
        } elseif (!$exprType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType && $this->reportMaybes && $isIterable->maybe()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, $exprType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->line($node->expr->getLine())->build()];
        }
        $anonymousFunctionReturnType = $scope->getAnonymousFunctionReturnType();
        $scopeFunction = $scope->getFunction();
        if ($anonymousFunctionReturnType !== null) {
            $returnType = $anonymousFunctionReturnType;
        } elseif ($scopeFunction !== null) {
            $returnType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($scopeFunction->getVariants())->getReturnType();
        } else {
            return [];
            // already reported by YieldInGeneratorRule
        }
        if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return [];
        }
        $messages = [];
        if (!$this->ruleLevelHelper->accepts($returnType->getIterableKeyType(), $exprType->getIterableKeyType(), $scope->isDeclareStrictTypes())) {
            $verbosityLevel = \_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($returnType->getIterableKeyType());
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Generator expects key type %s, %s given.', $returnType->getIterableKeyType()->describe($verbosityLevel), $exprType->getIterableKeyType()->describe($verbosityLevel)))->line($node->expr->getLine())->build();
        }
        if (!$this->ruleLevelHelper->accepts($returnType->getIterableValueType(), $exprType->getIterableValueType(), $scope->isDeclareStrictTypes())) {
            $verbosityLevel = \_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($returnType->getIterableValueType());
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Generator expects value type %s, %s given.', $returnType->getIterableValueType()->describe($verbosityLevel), $exprType->getIterableValueType()->describe($verbosityLevel)))->line($node->expr->getLine())->build();
        }
        $scopeFunction = $scope->getFunction();
        if ($scopeFunction === null) {
            return $messages;
        }
        if (!$exprType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return $messages;
        }
        $currentReturnType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($scopeFunction->getVariants())->getReturnType();
        if (!$currentReturnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return $messages;
        }
        $exprSendType = \_PhpScopere8e811afab72\PHPStan\Type\GenericTypeVariableResolver::getType($exprType, \Generator::class, 'TSend');
        $thisSendType = \_PhpScopere8e811afab72\PHPStan\Type\GenericTypeVariableResolver::getType($currentReturnType, \Generator::class, 'TSend');
        if ($exprSendType === null || $thisSendType === null) {
            return $messages;
        }
        $isSuperType = $exprSendType->isSuperTypeOf($thisSendType);
        if ($isSuperType->no()) {
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Generator expects delegated TSend type %s, %s given.', $exprSendType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $thisSendType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        } elseif ($this->reportMaybes && !$isSuperType->yes()) {
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Generator expects delegated TSend type %s, %s given.', $exprSendType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $thisSendType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        if ($scope->getType($node) instanceof \_PhpScopere8e811afab72\PHPStan\Type\VoidType && !$scope->isInFirstLevelStatement()) {
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Result of yield from (void) is used.')->build();
        }
        return $messages;
    }
}
