<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Type\GenericTypeVariableResolver;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NeverType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VoidType;
class FunctionReturnTypeCheck
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
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
    public function checkReturnType(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $returnType, ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $returnValue, string $emptyReturnStatementMessage, string $voidMessage, string $typeMismatchMessage, string $neverMessage, bool $isGenerator) : array
    {
        if ($returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType && $returnType->isExplicit()) {
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message($neverMessage)->build()];
        }
        if ($isGenerator) {
            if (!$returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
                return [];
            }
            $returnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\GenericTypeVariableResolver::getType($returnType, \Generator::class, 'TReturn');
            if ($returnType === null) {
                return [];
            }
        }
        $isVoidSuperType = (new \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType())->isSuperTypeOf($returnType);
        $verbosityLevel = \_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($returnType);
        if ($returnValue === null) {
            if (!$isVoidSuperType->no()) {
                return [];
            }
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($emptyReturnStatementMessage, $returnType->describe($verbosityLevel)))->build()];
        }
        $returnValueType = $scope->getType($returnValue);
        if ($isVoidSuperType->yes()) {
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($voidMessage, $returnValueType->describe($verbosityLevel)))->build()];
        }
        if (!$this->ruleLevelHelper->accepts($returnType, $returnValueType, $scope->isDeclareStrictTypes())) {
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($typeMismatchMessage, $returnType->describe($verbosityLevel), $returnValueType->describe($verbosityLevel)))->build()];
        }
        return [];
    }
}
