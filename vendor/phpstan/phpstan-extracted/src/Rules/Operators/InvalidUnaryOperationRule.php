<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Operators;

use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class InvalidUnaryOperationRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryPlus && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryMinus && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BitwiseNot) {
            return [];
        }
        if ($scope->getType($node) instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryPlus) {
                $operator = '+';
            } elseif ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryMinus) {
                $operator = '-';
            } else {
                $operator = '~';
            }
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Unary operation "%s" on %s results in an error.', $operator, $scope->getType($node->expr)->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value())))->line($node->expr->getLine())->build()];
        }
        return [];
    }
}
