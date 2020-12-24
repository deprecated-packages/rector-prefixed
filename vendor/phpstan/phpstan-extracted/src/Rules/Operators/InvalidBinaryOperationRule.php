<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Operators;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\MutatingScope;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class InvalidBinaryOperationRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PhpParser\PrettyPrinter\Standard */
    private $printer;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\PrettyPrinter\Standard $printer, \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->printer = $printer;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp) {
            return [];
        }
        if ($scope->getType($node) instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            $leftName = '__PHPSTAN__LEFT__';
            $rightName = '__PHPSTAN__RIGHT__';
            $leftVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($leftName);
            $rightVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($rightName);
            if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp) {
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
            if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Concat || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat) {
                $callback = static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool {
                    return !$type->toString() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
                };
            } else {
                $callback = static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool {
                    return !$type->toNumber() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
                };
            }
            $leftType = $this->ruleLevelHelper->findTypeToCheck($scope, $left, '', $callback)->getType();
            if ($leftType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
                return [];
            }
            $rightType = $this->ruleLevelHelper->findTypeToCheck($scope, $right, '', $callback)->getType();
            if ($rightType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
                return [];
            }
            if (!$scope instanceof \_PhpScoperb75b35f52b74\PHPStan\Analyser\MutatingScope) {
                throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
            }
            $scope = $scope->assignVariable($leftName, $leftType)->assignVariable($rightName, $rightType);
            if (!$scope->getType($newNode) instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
                return [];
            }
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Binary operation "%s" between %s and %s results in an error.', \substr(\substr($this->printer->prettyPrintExpr($newNode), \strlen($leftName) + 2), 0, -(\strlen($rightName) + 2)), $scope->getType($left)->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()), $scope->getType($right)->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value())))->line($left->getLine())->build()];
        }
        return [];
    }
}
