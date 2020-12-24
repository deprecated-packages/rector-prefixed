<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Arrays;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\Properties\PropertyReflectionFinder;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Assign>
 */
class AppendedArrayKeyTypeRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var PropertyReflectionFinder */
    private $propertyReflectionFinder;
    /** @var bool */
    private $checkUnionTypes;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder, bool $checkUnionTypes)
    {
        $this->propertyReflectionFinder = $propertyReflectionFinder;
        $this->checkUnionTypes = $checkUnionTypes;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            return [];
        }
        if (!$node->var->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch && !$node->var->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
            return [];
        }
        $propertyReflection = $this->propertyReflectionFinder->findPropertyReflectionFromNode($node->var->var, $scope);
        if ($propertyReflection === null) {
            return [];
        }
        $arrayType = $propertyReflection->getReadableType();
        if (!$arrayType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
            return [];
        }
        if ($node->var->dim !== null) {
            $dimensionType = $scope->getType($node->var->dim);
            $isValidKey = \_PhpScopere8e811afab72\PHPStan\Rules\Arrays\AllowedArrayKeysTypes::getType()->isSuperTypeOf($dimensionType);
            if (!$isValidKey->yes()) {
                // already handled by InvalidKeyInArrayDimFetchRule
                return [];
            }
            $keyType = \_PhpScopere8e811afab72\PHPStan\Type\ArrayType::castToArrayKeyType($dimensionType);
            if (!$this->checkUnionTypes && $keyType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
                return [];
            }
        } else {
            $keyType = new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType();
        }
        if (!$arrayType->getIterableKeyType()->isSuperTypeOf($keyType)->yes()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Array (%s) does not accept key %s.', $arrayType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $keyType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value())))->build()];
        }
        return [];
    }
}
