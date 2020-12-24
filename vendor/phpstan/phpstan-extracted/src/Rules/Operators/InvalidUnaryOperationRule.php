<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Operators;

use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class InvalidUnaryOperationRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\UnaryPlus && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\UnaryMinus && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BitwiseNot) {
            return [];
        }
        if ($scope->getType($node) instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType) {
            if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\UnaryPlus) {
                $operator = '+';
            } elseif ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\UnaryMinus) {
                $operator = '-';
            } else {
                $operator = '~';
            }
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Unary operation "%s" on %s results in an error.', $operator, $scope->getType($node->expr)->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value())))->line($node->expr->getLine())->build()];
        }
        return [];
    }
}
