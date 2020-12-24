<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Operators;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class InvalidUnaryOperationRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\UnaryPlus && !$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\UnaryMinus && !$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BitwiseNot) {
            return [];
        }
        if ($scope->getType($node) instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType) {
            if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\UnaryPlus) {
                $operator = '+';
            } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\UnaryMinus) {
                $operator = '-';
            } else {
                $operator = '~';
            }
            return [\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Unary operation "%s" on %s results in an error.', $operator, $scope->getType($node->expr)->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value())))->line($node->expr->getLine())->build()];
        }
        return [];
    }
}
