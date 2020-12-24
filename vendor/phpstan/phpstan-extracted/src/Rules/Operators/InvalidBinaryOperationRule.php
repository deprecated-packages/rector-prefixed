<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Operators;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\MutatingScope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class InvalidBinaryOperationRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    /** @var \PhpParser\PrettyPrinter\Standard */
    private $printer;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\PrettyPrinter\Standard $printer, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->printer = $printer;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp && !$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp) {
            return [];
        }
        if ($scope->getType($node) instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType) {
            $leftName = '__PHPSTAN__LEFT__';
            $rightName = '__PHPSTAN__RIGHT__';
            $leftVariable = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable($leftName);
            $rightVariable = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable($rightName);
            if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp) {
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
            if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\Concat || $node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Concat) {
                $callback = static function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : bool {
                    return !$type->toString() instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType;
                };
            } else {
                $callback = static function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : bool {
                    return !$type->toNumber() instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType;
                };
            }
            $leftType = $this->ruleLevelHelper->findTypeToCheck($scope, $left, '', $callback)->getType();
            if ($leftType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType) {
                return [];
            }
            $rightType = $this->ruleLevelHelper->findTypeToCheck($scope, $right, '', $callback)->getType();
            if ($rightType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType) {
                return [];
            }
            if (!$scope instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\MutatingScope) {
                throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
            }
            $scope = $scope->assignVariable($leftName, $leftType)->assignVariable($rightName, $rightType);
            if (!$scope->getType($newNode) instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType) {
                return [];
            }
            return [\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Binary operation "%s" between %s and %s results in an error.', \substr(\substr($this->printer->prettyPrintExpr($newNode), \strlen($leftName) + 2), 0, -(\strlen($rightName) + 2)), $scope->getType($left)->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value()), $scope->getType($right)->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value())))->line($left->getLine())->build()];
        }
        return [];
    }
}
