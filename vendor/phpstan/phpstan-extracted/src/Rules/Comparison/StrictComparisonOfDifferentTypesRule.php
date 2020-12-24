<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Comparison;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\BinaryOp>
 */
class StrictComparisonOfDifferentTypesRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkAlwaysTrueStrictComparison;
    public function __construct(bool $checkAlwaysTrueStrictComparison)
    {
        $this->checkAlwaysTrueStrictComparison = $checkAlwaysTrueStrictComparison;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return [];
        }
        $nodeType = $scope->getType($node);
        if (!$nodeType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType) {
            return [];
        }
        $leftType = $scope->getType($node->left);
        $rightType = $scope->getType($node->right);
        if (!$nodeType->getValue()) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Strict comparison using %s between %s and %s will always evaluate to false.', $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical ? '===' : '!==', $leftType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()), $rightType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value())))->build()];
        } elseif ($this->checkAlwaysTrueStrictComparison) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Strict comparison using %s between %s and %s will always evaluate to true.', $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical ? '===' : '!==', $leftType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()), $rightType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value())))->build()];
        }
        return [];
    }
}
