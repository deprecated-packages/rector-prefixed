<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Comparison;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\BinaryOp>
 */
class NumberComparisonOperatorsConstantConditionRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Greater && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Smaller && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual) {
            return [];
        }
        $exprType = $scope->getType($node);
        if ($exprType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Comparison operation "%s" between %s and %s is always %s.', $node->getOperatorSigil(), $scope->getType($node->left)->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()), $scope->getType($node->right)->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()), $exprType->getValue() ? 'true' : 'false'))->build()];
        }
        return [];
    }
}
