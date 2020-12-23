<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Functions;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntegerRangeType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
class RandomIntParametersRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    /** @var bool */
    private $reportMaybes;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider, bool $reportMaybes)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->reportMaybes = $reportMaybes;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
            return [];
        }
        if ($this->reflectionProvider->resolveFunctionName($node->name, $scope) !== 'random_int') {
            return [];
        }
        $minType = $scope->getType($node->args[0]->value)->toInteger();
        $maxType = $scope->getType($node->args[1]->value)->toInteger();
        $integerType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType();
        if ($minType->equals($integerType) || $maxType->equals($integerType)) {
            return [];
        }
        if ($minType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType || $minType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerRangeType) {
            if ($minType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType) {
                $maxPermittedType = \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerRangeType::fromInterval($minType->getValue(), \PHP_INT_MAX);
            } else {
                $maxPermittedType = \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerRangeType::fromInterval($minType->getMax(), \PHP_INT_MAX);
            }
            if (!$maxPermittedType->isSuperTypeOf($maxType)->yes()) {
                $message = 'Parameter #1 $min (%s) of function random_int expects lower number than parameter #2 $max (%s).';
                // True if sometimes the parameters conflict.
                $isMaybe = !$maxType->isSuperTypeOf($minType)->no();
                if (!$isMaybe || $this->reportMaybes) {
                    return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($message, $minType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value()), $maxType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value())))->build()];
                }
            }
        }
        return [];
    }
}
