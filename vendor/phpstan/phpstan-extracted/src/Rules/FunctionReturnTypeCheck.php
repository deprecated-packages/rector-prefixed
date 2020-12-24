<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Type\GenericTypeVariableResolver;
use _PhpScopere8e811afab72\PHPStan\Type\NeverType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
use _PhpScopere8e811afab72\PHPStan\Type\VoidType;
class FunctionReturnTypeCheck
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
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
    public function checkReturnType(\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, \_PhpScopere8e811afab72\PHPStan\Type\Type $returnType, ?\_PhpScopere8e811afab72\PhpParser\Node\Expr $returnValue, string $emptyReturnStatementMessage, string $voidMessage, string $typeMismatchMessage, string $neverMessage, bool $isGenerator) : array
    {
        if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType && $returnType->isExplicit()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message($neverMessage)->build()];
        }
        if ($isGenerator) {
            if (!$returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
                return [];
            }
            $returnType = \_PhpScopere8e811afab72\PHPStan\Type\GenericTypeVariableResolver::getType($returnType, \Generator::class, 'TReturn');
            if ($returnType === null) {
                return [];
            }
        }
        $isVoidSuperType = (new \_PhpScopere8e811afab72\PHPStan\Type\VoidType())->isSuperTypeOf($returnType);
        $verbosityLevel = \_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($returnType);
        if ($returnValue === null) {
            if (!$isVoidSuperType->no()) {
                return [];
            }
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($emptyReturnStatementMessage, $returnType->describe($verbosityLevel)))->build()];
        }
        $returnValueType = $scope->getType($returnValue);
        if ($isVoidSuperType->yes()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($voidMessage, $returnValueType->describe($verbosityLevel)))->build()];
        }
        if (!$this->ruleLevelHelper->accepts($returnType, $returnValueType, $scope->isDeclareStrictTypes())) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($typeMismatchMessage, $returnType->describe($verbosityLevel), $returnValueType->describe($verbosityLevel)))->build()];
        }
        return [];
    }
}
