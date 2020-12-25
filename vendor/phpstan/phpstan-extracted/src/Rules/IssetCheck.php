<?php

declare (strict_types=1);
namespace PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Properties\PropertyDescriptor;
use PHPStan\Rules\Properties\PropertyReflectionFinder;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
class IssetCheck
{
    /** @var \PHPStan\Rules\Properties\PropertyDescriptor */
    private $propertyDescriptor;
    /** @var \PHPStan\Rules\Properties\PropertyReflectionFinder */
    private $propertyReflectionFinder;
    public function __construct(\PHPStan\Rules\Properties\PropertyDescriptor $propertyDescriptor, \PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder)
    {
        $this->propertyDescriptor = $propertyDescriptor;
        $this->propertyReflectionFinder = $propertyReflectionFinder;
    }
    public function check(\PhpParser\Node\Expr $expr, \PHPStan\Analyser\Scope $scope, string $operatorDescription, ?\PHPStan\Rules\RuleError $error = null) : ?\PHPStan\Rules\RuleError
    {
        if ($expr instanceof \PhpParser\Node\Expr\Variable && \is_string($expr->name)) {
            $hasVariable = $scope->hasVariableType($expr->name);
            if ($hasVariable->maybe()) {
                return null;
            }
            return $error;
        } elseif ($expr instanceof \PhpParser\Node\Expr\ArrayDimFetch && $expr->dim !== null) {
            $type = $scope->getType($expr->var);
            $dimType = $scope->getType($expr->dim);
            $hasOffsetValue = $type->hasOffsetValueType($dimType);
            if (!$type->isOffsetAccessible()->yes()) {
                return $error;
            }
            if ($hasOffsetValue->no()) {
                return $error ?? \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Offset %s on %s %s does not exist.', $dimType->describe(\PHPStan\Type\VerbosityLevel::value()), $type->describe(\PHPStan\Type\VerbosityLevel::value()), $operatorDescription))->build();
            }
            if ($hasOffsetValue->maybe()) {
                return null;
            }
            // If offset is cannot be null, store this error message and see if one of the earlier offsets is.
            // E.g. $array['a']['b']['c'] ?? null; is a valid coalesce if a OR b or C might be null.
            if ($hasOffsetValue->yes()) {
                $error = $error ?? $this->generateError($type->getOffsetValueType($dimType), \sprintf('Offset %s on %s %s always exists and', $dimType->describe(\PHPStan\Type\VerbosityLevel::value()), $type->describe(\PHPStan\Type\VerbosityLevel::value()), $operatorDescription));
                if ($error !== null) {
                    return $this->check($expr->var, $scope, $operatorDescription, $error);
                }
            }
            // Has offset, it is nullable
            return null;
        } elseif ($expr instanceof \PhpParser\Node\Expr\PropertyFetch || $expr instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
            $propertyReflection = $this->propertyReflectionFinder->findPropertyReflectionFromNode($expr, $scope);
            if ($propertyReflection === null) {
                return null;
            }
            if (!$propertyReflection->isNative()) {
                return null;
            }
            $nativeType = $propertyReflection->getNativeType();
            if (!$nativeType instanceof \PHPStan\Type\MixedType) {
                if (!$scope->isSpecified($expr)) {
                    return null;
                }
            }
            $propertyDescription = $this->propertyDescriptor->describeProperty($propertyReflection, $expr);
            $propertyType = $propertyReflection->getWritableType();
            $error = $error ?? $this->generateError($propertyReflection->getWritableType(), \sprintf('%s (%s) %s', $propertyDescription, $propertyType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $operatorDescription));
            if ($error !== null) {
                if ($expr instanceof \PhpParser\Node\Expr\PropertyFetch) {
                    return $this->check($expr->var, $scope, $operatorDescription, $error);
                }
                if ($expr->class instanceof \PhpParser\Node\Expr) {
                    return $this->check($expr->class, $scope, $operatorDescription, $error);
                }
            }
            return $error;
        }
        return $error ?? $this->generateError($scope->getType($expr), \sprintf('Expression %s', $operatorDescription));
    }
    private function generateError(\PHPStan\Type\Type $type, string $message) : ?\PHPStan\Rules\RuleError
    {
        $nullType = new \PHPStan\Type\NullType();
        if ($type->equals($nullType)) {
            return \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s is always null.', $message))->build();
        }
        if ($type->isSuperTypeOf($nullType)->no()) {
            return \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s is not nullable.', $message))->build();
        }
        return null;
    }
}
