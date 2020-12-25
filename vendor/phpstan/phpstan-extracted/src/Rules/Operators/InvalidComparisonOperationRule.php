<?php

declare (strict_types=1);
namespace PHPStan\Rules\Operators;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\BinaryOp>
 */
class InvalidComparisonOperationRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\BinaryOp::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \PhpParser\Node\Expr\BinaryOp\Equal && !$node instanceof \PhpParser\Node\Expr\BinaryOp\NotEqual && !$node instanceof \PhpParser\Node\Expr\BinaryOp\Smaller && !$node instanceof \PhpParser\Node\Expr\BinaryOp\SmallerOrEqual && !$node instanceof \PhpParser\Node\Expr\BinaryOp\Greater && !$node instanceof \PhpParser\Node\Expr\BinaryOp\GreaterOrEqual && !$node instanceof \PhpParser\Node\Expr\BinaryOp\Spaceship) {
            return [];
        }
        if ($this->isNumberType($scope, $node->left) && ($this->isObjectType($scope, $node->right) || $this->isArrayType($scope, $node->right)) || $this->isNumberType($scope, $node->right) && ($this->isObjectType($scope, $node->left) || $this->isArrayType($scope, $node->left))) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Comparison operation "%s" between %s and %s results in an error.', $node->getOperatorSigil(), $scope->getType($node->left)->describe(\PHPStan\Type\VerbosityLevel::value()), $scope->getType($node->right)->describe(\PHPStan\Type\VerbosityLevel::value())))->line($node->left->getLine())->build()];
        }
        return [];
    }
    private function isNumberType(\PHPStan\Analyser\Scope $scope, \PhpParser\Node\Expr $expr) : bool
    {
        $acceptedType = new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType()]);
        $onlyNumber = static function (\PHPStan\Type\Type $type) use($acceptedType) : bool {
            return $acceptedType->accepts($type, \true)->yes();
        };
        $type = $this->ruleLevelHelper->findTypeToCheck($scope, $expr, '', $onlyNumber)->getType();
        if ($type instanceof \PHPStan\Type\ErrorType || !$type->equals($scope->getType($expr))) {
            return \false;
        }
        return !$acceptedType->isSuperTypeOf($type)->no();
    }
    private function isObjectType(\PHPStan\Analyser\Scope $scope, \PhpParser\Node\Expr $expr) : bool
    {
        $acceptedType = new \PHPStan\Type\ObjectWithoutClassType();
        $type = $this->ruleLevelHelper->findTypeToCheck($scope, $expr, '', static function (\PHPStan\Type\Type $type) use($acceptedType) : bool {
            return $acceptedType->isSuperTypeOf($type)->yes();
        })->getType();
        if ($type instanceof \PHPStan\Type\ErrorType) {
            return \false;
        }
        $isSuperType = $acceptedType->isSuperTypeOf($type);
        if ($type instanceof \PHPStan\Type\BenevolentUnionType) {
            return !$isSuperType->no();
        }
        return $isSuperType->yes();
    }
    private function isArrayType(\PHPStan\Analyser\Scope $scope, \PhpParser\Node\Expr $expr) : bool
    {
        $type = $this->ruleLevelHelper->findTypeToCheck($scope, $expr, '', static function (\PHPStan\Type\Type $type) : bool {
            return $type->isArray()->yes();
        })->getType();
        return !$type instanceof \PHPStan\Type\ErrorType && $type->isArray()->yes();
    }
}
