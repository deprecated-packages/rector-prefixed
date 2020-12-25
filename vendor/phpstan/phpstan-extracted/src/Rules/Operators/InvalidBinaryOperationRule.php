<?php

declare (strict_types=1);
namespace PHPStan\Rules\Operators;

use PhpParser\Node;
use PHPStan\Analyser\MutatingScope;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class InvalidBinaryOperationRule implements \PHPStan\Rules\Rule
{
    /** @var \PhpParser\PrettyPrinter\Standard */
    private $printer;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\PhpParser\PrettyPrinter\Standard $printer, \PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->printer = $printer;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \PhpParser\Node\Expr\BinaryOp && !$node instanceof \PhpParser\Node\Expr\AssignOp) {
            return [];
        }
        if ($scope->getType($node) instanceof \PHPStan\Type\ErrorType) {
            $leftName = '__PHPSTAN__LEFT__';
            $rightName = '__PHPSTAN__RIGHT__';
            $leftVariable = new \PhpParser\Node\Expr\Variable($leftName);
            $rightVariable = new \PhpParser\Node\Expr\Variable($rightName);
            if ($node instanceof \PhpParser\Node\Expr\AssignOp) {
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
            if ($node instanceof \PhpParser\Node\Expr\AssignOp\Concat || $node instanceof \PhpParser\Node\Expr\BinaryOp\Concat) {
                $callback = static function (\PHPStan\Type\Type $type) : bool {
                    return !$type->toString() instanceof \PHPStan\Type\ErrorType;
                };
            } else {
                $callback = static function (\PHPStan\Type\Type $type) : bool {
                    return !$type->toNumber() instanceof \PHPStan\Type\ErrorType;
                };
            }
            $leftType = $this->ruleLevelHelper->findTypeToCheck($scope, $left, '', $callback)->getType();
            if ($leftType instanceof \PHPStan\Type\ErrorType) {
                return [];
            }
            $rightType = $this->ruleLevelHelper->findTypeToCheck($scope, $right, '', $callback)->getType();
            if ($rightType instanceof \PHPStan\Type\ErrorType) {
                return [];
            }
            if (!$scope instanceof \PHPStan\Analyser\MutatingScope) {
                throw new \PHPStan\ShouldNotHappenException();
            }
            $scope = $scope->assignVariable($leftName, $leftType)->assignVariable($rightName, $rightType);
            if (!$scope->getType($newNode) instanceof \PHPStan\Type\ErrorType) {
                return [];
            }
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Binary operation "%s" between %s and %s results in an error.', \substr(\substr($this->printer->prettyPrintExpr($newNode), \strlen($leftName) + 2), 0, -(\strlen($rightName) + 2)), $scope->getType($left)->describe(\PHPStan\Type\VerbosityLevel::value()), $scope->getType($right)->describe(\PHPStan\Type\VerbosityLevel::value())))->line($left->getLine())->build()];
        }
        return [];
    }
}
