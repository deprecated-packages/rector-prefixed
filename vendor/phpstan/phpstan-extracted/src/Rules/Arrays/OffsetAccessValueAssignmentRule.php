<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Arrays;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<Expr>
 */
class OffsetAccessValueAssignmentRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            return [];
        }
        $arrayDimFetch = $node->var;
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignRef) {
            $assignedValueType = $scope->getType($node->expr);
        } else {
            $assignedValueType = $scope->getType($node);
        }
        $originalArrayType = $scope->getType($arrayDimFetch->var);
        $arrayTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $arrayDimFetch->var, '', static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $varType) use($assignedValueType) : bool {
            $result = $varType->setOffsetValueType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $assignedValueType);
            return !$result instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType;
        });
        $arrayType = $arrayTypeResult->getType();
        if ($arrayType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
            return [];
        }
        $isOffsetAccessible = $arrayType->isOffsetAccessible();
        if (!$isOffsetAccessible->yes()) {
            return [];
        }
        $resultType = $arrayType->setOffsetValueType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $assignedValueType);
        if (!$resultType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
            return [];
        }
        return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s does not accept %s.', $originalArrayType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value()), $assignedValueType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
