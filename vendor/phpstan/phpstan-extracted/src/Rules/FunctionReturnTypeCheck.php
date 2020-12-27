<?php

declare (strict_types=1);
namespace PHPStan\Rules;

use PhpParser\Node\Expr;
use PHPStan\Analyser\Scope;
use PHPStan\Type\GenericTypeVariableResolver;
use PHPStan\Type\NeverType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\VerbosityLevel;
use PHPStan\Type\VoidType;
class FunctionReturnTypeCheck
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    /**
     * @param \PHPStan\Analyser\Scope $scope
     * @param \PHPStan\Type\Type $returnType
     * @param \PhpParser\Node\Expr|null $returnValue
     * @param string $emptyReturnStatementMessage
     * @param string $voidMessage
     * @param string $typeMismatchMessage
     * @param bool $isGenerator
     * @return RuleError[]
     */
    public function checkReturnType(\PHPStan\Analyser\Scope $scope, \PHPStan\Type\Type $returnType, ?\PhpParser\Node\Expr $returnValue, string $emptyReturnStatementMessage, string $voidMessage, string $typeMismatchMessage, string $neverMessage, bool $isGenerator) : array
    {
        if ($returnType instanceof \PHPStan\Type\NeverType && $returnType->isExplicit()) {
            return [\PHPStan\Rules\RuleErrorBuilder::message($neverMessage)->build()];
        }
        if ($isGenerator) {
            if (!$returnType instanceof \PHPStan\Type\TypeWithClassName) {
                return [];
            }
            $returnType = \PHPStan\Type\GenericTypeVariableResolver::getType($returnType, \Generator::class, 'TReturn');
            if ($returnType === null) {
                return [];
            }
        }
        $isVoidSuperType = (new \PHPStan\Type\VoidType())->isSuperTypeOf($returnType);
        $verbosityLevel = \PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($returnType);
        if ($returnValue === null) {
            if (!$isVoidSuperType->no()) {
                return [];
            }
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($emptyReturnStatementMessage, $returnType->describe($verbosityLevel)))->build()];
        }
        $returnValueType = $scope->getType($returnValue);
        if ($isVoidSuperType->yes()) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($voidMessage, $returnValueType->describe($verbosityLevel)))->build()];
        }
        if (!$this->ruleLevelHelper->accepts($returnType, $returnValueType, $scope->isDeclareStrictTypes())) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($typeMismatchMessage, $returnType->describe($verbosityLevel), $returnValueType->describe($verbosityLevel)))->build()];
        }
        return [];
    }
}
