<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Comparison;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType;
class ConstantConditionRuleHelper
{
    /** @var ImpossibleCheckTypeHelper */
    private $impossibleCheckTypeHelper;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper $impossibleCheckTypeHelper, bool $treatPhpDocTypesAsCertain)
    {
        $this->impossibleCheckTypeHelper = $impossibleCheckTypeHelper;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function shouldReportAlwaysTrueByDefault(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : bool
    {
        return $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanOr || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanAnd || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Isset_;
    }
    public function shouldSkip(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Instanceof_ || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanOr || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanAnd || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Isset_ || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Greater || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Smaller || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual) {
            // already checked by different rules
            return \true;
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall || $expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall) {
            $isAlways = $this->impossibleCheckTypeHelper->findSpecifiedType($scope, $expr);
            if ($isAlways !== null) {
                return \true;
            }
        }
        return \false;
    }
    public function getBooleanType(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType
    {
        if ($this->shouldSkip($scope, $expr)) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType();
        }
        if ($this->treatPhpDocTypesAsCertain) {
            return $scope->getType($expr)->toBoolean();
        }
        return $scope->getNativeType($expr)->toBoolean();
    }
    public function getNativeBooleanType(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType
    {
        if ($this->shouldSkip($scope, $expr)) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType();
        }
        return $scope->getNativeType($expr)->toBoolean();
    }
}
