<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Comparison;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\BinaryOp>
 */
class StrictComparisonOfDifferentTypesRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkAlwaysTrueStrictComparison;
    public function __construct(bool $checkAlwaysTrueStrictComparison)
    {
        $this->checkAlwaysTrueStrictComparison = $checkAlwaysTrueStrictComparison;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return [];
        }
        $nodeType = $scope->getType($node);
        if (!$nodeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType) {
            return [];
        }
        $leftType = $scope->getType($node->left);
        $rightType = $scope->getType($node->right);
        if (!$nodeType->getValue()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Strict comparison using %s between %s and %s will always evaluate to false.', $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical ? '===' : '!==', $leftType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value()), $rightType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value())))->build()];
        } elseif ($this->checkAlwaysTrueStrictComparison) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Strict comparison using %s between %s and %s will always evaluate to true.', $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical ? '===' : '!==', $leftType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value()), $rightType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value())))->build()];
        }
        return [];
    }
}
