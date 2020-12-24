<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Comparison;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\BinaryOp>
 */
class NumberComparisonOperatorsConstantConditionRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Greater && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Smaller && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual) {
            return [];
        }
        $exprType = $scope->getType($node);
        if ($exprType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Comparison operation "%s" between %s and %s is always %s.', $node->getOperatorSigil(), $scope->getType($node->left)->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value()), $scope->getType($node->right)->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value()), $exprType->getValue() ? 'true' : 'false'))->build()];
        }
        return [];
    }
}
