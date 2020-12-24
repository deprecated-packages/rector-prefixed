<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Operators;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\MutatingScope;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class InvalidBinaryOperationRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PhpParser\PrettyPrinter\Standard */
    private $printer;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\PrettyPrinter\Standard $printer, \_PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->printer = $printer;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp) {
            return [];
        }
        if ($scope->getType($node) instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
            $leftName = '__PHPSTAN__LEFT__';
            $rightName = '__PHPSTAN__RIGHT__';
            $leftVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($leftName);
            $rightVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($rightName);
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp) {
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
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Concat || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat) {
                $callback = static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool {
                    return !$type->toString() instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType;
                };
            } else {
                $callback = static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool {
                    return !$type->toNumber() instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType;
                };
            }
            $leftType = $this->ruleLevelHelper->findTypeToCheck($scope, $left, '', $callback)->getType();
            if ($leftType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
                return [];
            }
            $rightType = $this->ruleLevelHelper->findTypeToCheck($scope, $right, '', $callback)->getType();
            if ($rightType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
                return [];
            }
            if (!$scope instanceof \_PhpScopere8e811afab72\PHPStan\Analyser\MutatingScope) {
                throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
            }
            $scope = $scope->assignVariable($leftName, $leftType)->assignVariable($rightName, $rightType);
            if (!$scope->getType($newNode) instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
                return [];
            }
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Binary operation "%s" between %s and %s results in an error.', \substr(\substr($this->printer->prettyPrintExpr($newNode), \strlen($leftName) + 2), 0, -(\strlen($rightName) + 2)), $scope->getType($left)->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value()), $scope->getType($right)->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value())))->line($left->getLine())->build()];
        }
        return [];
    }
}
