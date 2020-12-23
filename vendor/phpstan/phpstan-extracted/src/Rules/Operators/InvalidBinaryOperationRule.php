<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Operators;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\MutatingScope;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class InvalidBinaryOperationRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var \PhpParser\PrettyPrinter\Standard */
    private $printer;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\PrettyPrinter\Standard $printer, \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->printer = $printer;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\AssignOp) {
            return [];
        }
        if ($scope->getType($node) instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType) {
            $leftName = '__PHPSTAN__LEFT__';
            $rightName = '__PHPSTAN__RIGHT__';
            $leftVariable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable($leftName);
            $rightVariable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable($rightName);
            if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\AssignOp) {
                $newNode = clone $node;
                $left = $node->var;
                $right = $node->expr;
                $newNode->var = $leftVariable;
                $newNode->expr = $rightVariable;
            } else {
                $newNode = clone $node;
                $left = $node->left;
                $right = $node->right;
                $newNode->left = $leftVariable;
                $newNode->right = $rightVariable;
            }
            if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\AssignOp\Concat || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat) {
                $callback = static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool {
                    return !$type->toString() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
                };
            } else {
                $callback = static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool {
                    return !$type->toNumber() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
                };
            }
            $leftType = $this->ruleLevelHelper->findTypeToCheck($scope, $left, '', $callback)->getType();
            if ($leftType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType) {
                return [];
            }
            $rightType = $this->ruleLevelHelper->findTypeToCheck($scope, $right, '', $callback)->getType();
            if ($rightType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType) {
                return [];
            }
            if (!$scope instanceof \_PhpScoper0a2ac50786fa\PHPStan\Analyser\MutatingScope) {
                throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
            }
            $scope = $scope->assignVariable($leftName, $leftType)->assignVariable($rightName, $rightType);
            if (!$scope->getType($newNode) instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType) {
                return [];
            }
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Binary operation "%s" between %s and %s results in an error.', \substr(\substr($this->printer->prettyPrintExpr($newNode), \strlen($leftName) + 2), 0, -(\strlen($rightName) + 2)), $scope->getType($left)->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value()), $scope->getType($right)->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value())))->line($left->getLine())->build()];
        }
        return [];
    }
}
