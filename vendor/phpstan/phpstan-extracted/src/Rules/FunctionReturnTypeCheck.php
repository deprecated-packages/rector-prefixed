<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Type\GenericTypeVariableResolver;
use _PhpScoperb75b35f52b74\PHPStan\Type\NeverType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
use _PhpScoperb75b35f52b74\PHPStan\Type\VoidType;
class FunctionReturnTypeCheck
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
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
    public function checkReturnType(\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $returnType, ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $returnValue, string $emptyReturnStatementMessage, string $voidMessage, string $typeMismatchMessage, string $neverMessage, bool $isGenerator) : array
    {
        if ($returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType && $returnType->isExplicit()) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message($neverMessage)->build()];
        }
        if ($isGenerator) {
            if (!$returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
                return [];
            }
            $returnType = \_PhpScoperb75b35f52b74\PHPStan\Type\GenericTypeVariableResolver::getType($returnType, \Generator::class, 'TReturn');
            if ($returnType === null) {
                return [];
            }
        }
        $isVoidSuperType = (new \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType())->isSuperTypeOf($returnType);
        $verbosityLevel = \_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($returnType);
        if ($returnValue === null) {
            if (!$isVoidSuperType->no()) {
                return [];
            }
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($emptyReturnStatementMessage, $returnType->describe($verbosityLevel)))->build()];
        }
        $returnValueType = $scope->getType($returnValue);
        if ($isVoidSuperType->yes()) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($voidMessage, $returnValueType->describe($verbosityLevel)))->build()];
        }
        if (!$this->ruleLevelHelper->accepts($returnType, $returnValueType, $scope->isDeclareStrictTypes())) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($typeMismatchMessage, $returnType->describe($verbosityLevel), $returnValueType->describe($verbosityLevel)))->build()];
        }
        return [];
    }
}
