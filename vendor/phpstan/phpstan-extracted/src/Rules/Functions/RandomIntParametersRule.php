<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Functions;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerRangeType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
class RandomIntParametersRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    /** @var bool */
    private $reportMaybes;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider, bool $reportMaybes)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->reportMaybes = $reportMaybes;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            return [];
        }
        if ($this->reflectionProvider->resolveFunctionName($node->name, $scope) !== 'random_int') {
            return [];
        }
        $minType = $scope->getType($node->args[0]->value)->toInteger();
        $maxType = $scope->getType($node->args[1]->value)->toInteger();
        $integerType = new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType();
        if ($minType->equals($integerType) || $maxType->equals($integerType)) {
            return [];
        }
        if ($minType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType || $minType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntegerRangeType) {
            if ($minType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType) {
                $maxPermittedType = \_PhpScopere8e811afab72\PHPStan\Type\IntegerRangeType::fromInterval($minType->getValue(), \PHP_INT_MAX);
            } else {
                $maxPermittedType = \_PhpScopere8e811afab72\PHPStan\Type\IntegerRangeType::fromInterval($minType->getMax(), \PHP_INT_MAX);
            }
            if (!$maxPermittedType->isSuperTypeOf($maxType)->yes()) {
                $message = 'Parameter #1 $min (%s) of function random_int expects lower number than parameter #2 $max (%s).';
                // True if sometimes the parameters conflict.
                $isMaybe = !$maxType->isSuperTypeOf($minType)->no();
                if (!$isMaybe || $this->reportMaybes) {
                    return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($message, $minType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value()), $maxType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value())))->build()];
                }
            }
        }
        return [];
    }
}
