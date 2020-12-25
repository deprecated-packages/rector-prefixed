<?php

declare (strict_types=1);
namespace PHPStan\Rules\Generators;

use PhpParser\Node;
use PhpParser\Node\Expr\YieldFrom;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\GenericTypeVariableResolver;
use PHPStan\Type\MixedType;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\VerbosityLevel;
use PHPStan\Type\VoidType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\YieldFrom>
 */
class YieldFromTypeRule implements \PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var bool */
    private $reportMaybes;
    public function __construct(\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, bool $reportMaybes)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->reportMaybes = $reportMaybes;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\YieldFrom::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $exprType = $scope->getType($node->expr);
        $isIterable = $exprType->isIterable();
        $messagePattern = 'Argument of an invalid type %s passed to yield from, only iterables are supported.';
        if ($isIterable->no()) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, $exprType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->line($node->expr->getLine())->build()];
        } elseif (!$exprType instanceof \PHPStan\Type\MixedType && $this->reportMaybes && $isIterable->maybe()) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, $exprType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->line($node->expr->getLine())->build()];
        }
        $anonymousFunctionReturnType = $scope->getAnonymousFunctionReturnType();
        $scopeFunction = $scope->getFunction();
        if ($anonymousFunctionReturnType !== null) {
            $returnType = $anonymousFunctionReturnType;
        } elseif ($scopeFunction !== null) {
            $returnType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($scopeFunction->getVariants())->getReturnType();
        } else {
            return [];
            // already reported by YieldInGeneratorRule
        }
        if ($returnType instanceof \PHPStan\Type\MixedType) {
            return [];
        }
        $messages = [];
        if (!$this->ruleLevelHelper->accepts($returnType->getIterableKeyType(), $exprType->getIterableKeyType(), $scope->isDeclareStrictTypes())) {
            $verbosityLevel = \PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($returnType->getIterableKeyType());
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Generator expects key type %s, %s given.', $returnType->getIterableKeyType()->describe($verbosityLevel), $exprType->getIterableKeyType()->describe($verbosityLevel)))->line($node->expr->getLine())->build();
        }
        if (!$this->ruleLevelHelper->accepts($returnType->getIterableValueType(), $exprType->getIterableValueType(), $scope->isDeclareStrictTypes())) {
            $verbosityLevel = \PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($returnType->getIterableValueType());
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Generator expects value type %s, %s given.', $returnType->getIterableValueType()->describe($verbosityLevel), $exprType->getIterableValueType()->describe($verbosityLevel)))->line($node->expr->getLine())->build();
        }
        $scopeFunction = $scope->getFunction();
        if ($scopeFunction === null) {
            return $messages;
        }
        if (!$exprType instanceof \PHPStan\Type\TypeWithClassName) {
            return $messages;
        }
        $currentReturnType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($scopeFunction->getVariants())->getReturnType();
        if (!$currentReturnType instanceof \PHPStan\Type\TypeWithClassName) {
            return $messages;
        }
        $exprSendType = \PHPStan\Type\GenericTypeVariableResolver::getType($exprType, \Generator::class, 'TSend');
        $thisSendType = \PHPStan\Type\GenericTypeVariableResolver::getType($currentReturnType, \Generator::class, 'TSend');
        if ($exprSendType === null || $thisSendType === null) {
            return $messages;
        }
        $isSuperType = $exprSendType->isSuperTypeOf($thisSendType);
        if ($isSuperType->no()) {
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Generator expects delegated TSend type %s, %s given.', $exprSendType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $thisSendType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        } elseif ($this->reportMaybes && !$isSuperType->yes()) {
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Generator expects delegated TSend type %s, %s given.', $exprSendType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $thisSendType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        if ($scope->getType($node) instanceof \PHPStan\Type\VoidType && !$scope->isInFirstLevelStatement()) {
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message('Result of yield from (void) is used.')->build();
        }
        return $messages;
    }
}
