<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Operators;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class InvalidUnaryOperationRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\UnaryPlus && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\UnaryMinus && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BitwiseNot) {
            return [];
        }
        if ($scope->getType($node) instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\UnaryPlus) {
                $operator = '+';
            } elseif ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\UnaryMinus) {
                $operator = '-';
            } else {
                $operator = '~';
            }
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Unary operation "%s" on %s results in an error.', $operator, $scope->getType($node->expr)->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value())))->line($node->expr->getLine())->build()];
        }
        return [];
    }
}
