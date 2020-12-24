<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Operators;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\BinaryOp>
 */
class InvalidComparisonOperationRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Equal && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotEqual && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Smaller && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Greater && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Spaceship) {
            return [];
        }
        if ($this->isNumberType($scope, $node->left) && ($this->isObjectType($scope, $node->right) || $this->isArrayType($scope, $node->right)) || $this->isNumberType($scope, $node->right) && ($this->isObjectType($scope, $node->left) || $this->isArrayType($scope, $node->left))) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Comparison operation "%s" between %s and %s results in an error.', $node->getOperatorSigil(), $scope->getType($node->left)->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()), $scope->getType($node->right)->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value())))->line($node->left->getLine())->build()];
        }
        return [];
    }
    private function isNumberType(\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        $acceptedType = new \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType()]);
        $onlyNumber = static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($acceptedType) : bool {
            return $acceptedType->accepts($type, \true)->yes();
        };
        $type = $this->ruleLevelHelper->findTypeToCheck($scope, $expr, '', $onlyNumber)->getType();
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType || !$type->equals($scope->getType($expr))) {
            return \false;
        }
        return !$acceptedType->isSuperTypeOf($type)->no();
    }
    private function isObjectType(\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        $acceptedType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType();
        $type = $this->ruleLevelHelper->findTypeToCheck($scope, $expr, '', static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($acceptedType) : bool {
            return $acceptedType->isSuperTypeOf($type)->yes();
        })->getType();
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            return \false;
        }
        $isSuperType = $acceptedType->isSuperTypeOf($type);
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\BenevolentUnionType) {
            return !$isSuperType->no();
        }
        return $isSuperType->yes();
    }
    private function isArrayType(\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        $type = $this->ruleLevelHelper->findTypeToCheck($scope, $expr, '', static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool {
            return $type->isArray()->yes();
        })->getType();
        return !$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType && $type->isArray()->yes();
    }
}
