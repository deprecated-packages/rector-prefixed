<?php

declare (strict_types=1);
namespace PHPStan\Rules\Comparison;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Type\BooleanType;
class ConstantConditionRuleHelper
{
    /** @var ImpossibleCheckTypeHelper */
    private $impossibleCheckTypeHelper;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function __construct(\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper $impossibleCheckTypeHelper, bool $treatPhpDocTypesAsCertain)
    {
        $this->impossibleCheckTypeHelper = $impossibleCheckTypeHelper;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function shouldReportAlwaysTrueByDefault(\PhpParser\Node\Expr $expr) : bool
    {
        return $expr instanceof \PhpParser\Node\Expr\BooleanNot || $expr instanceof \PhpParser\Node\Expr\BinaryOp\BooleanOr || $expr instanceof \PhpParser\Node\Expr\BinaryOp\BooleanAnd || $expr instanceof \PhpParser\Node\Expr\Ternary || $expr instanceof \PhpParser\Node\Expr\Isset_;
    }
    public function shouldSkip(\PHPStan\Analyser\Scope $scope, \PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \PhpParser\Node\Expr\Instanceof_ || $expr instanceof \PhpParser\Node\Expr\BinaryOp\Identical || $expr instanceof \PhpParser\Node\Expr\BinaryOp\NotIdentical || $expr instanceof \PhpParser\Node\Expr\BooleanNot || $expr instanceof \PhpParser\Node\Expr\BinaryOp\BooleanOr || $expr instanceof \PhpParser\Node\Expr\BinaryOp\BooleanAnd || $expr instanceof \PhpParser\Node\Expr\Ternary || $expr instanceof \PhpParser\Node\Expr\Isset_ || $expr instanceof \PhpParser\Node\Expr\BinaryOp\Greater || $expr instanceof \PhpParser\Node\Expr\BinaryOp\GreaterOrEqual || $expr instanceof \PhpParser\Node\Expr\BinaryOp\Smaller || $expr instanceof \PhpParser\Node\Expr\BinaryOp\SmallerOrEqual) {
            // already checked by different rules
            return \true;
        }
        if ($expr instanceof \PhpParser\Node\Expr\FuncCall || $expr instanceof \PhpParser\Node\Expr\MethodCall || $expr instanceof \PhpParser\Node\Expr\StaticCall) {
            $isAlways = $this->impossibleCheckTypeHelper->findSpecifiedType($scope, $expr);
            if ($isAlways !== null) {
                return \true;
            }
        }
        return \false;
    }
    public function getBooleanType(\PHPStan\Analyser\Scope $scope, \PhpParser\Node\Expr $expr) : \PHPStan\Type\BooleanType
    {
        if ($this->shouldSkip($scope, $expr)) {
            return new \PHPStan\Type\BooleanType();
        }
        if ($this->treatPhpDocTypesAsCertain) {
            return $scope->getType($expr)->toBoolean();
        }
        return $scope->getNativeType($expr)->toBoolean();
    }
    public function getNativeBooleanType(\PHPStan\Analyser\Scope $scope, \PhpParser\Node\Expr $expr) : \PHPStan\Type\BooleanType
    {
        if ($this->shouldSkip($scope, $expr)) {
            return new \PHPStan\Type\BooleanType();
        }
        return $scope->getNativeType($expr)->toBoolean();
    }
}
