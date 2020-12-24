<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Properties\PropertyDescriptor;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Properties\PropertyReflectionFinder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel;
class IssetCheck
{
    /** @var \PHPStan\Rules\Properties\PropertyDescriptor */
    private $propertyDescriptor;
    /** @var \PHPStan\Rules\Properties\PropertyReflectionFinder */
    private $propertyReflectionFinder;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Properties\PropertyDescriptor $propertyDescriptor, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder)
    {
        $this->propertyDescriptor = $propertyDescriptor;
        $this->propertyReflectionFinder = $propertyReflectionFinder;
    }
    public function check(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope, string $operatorDescription, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleError $error = null) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleError
    {
        if ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable && \is_string($expr->name)) {
            $hasVariable = $scope->hasVariableType($expr->name);
            if ($hasVariable->maybe()) {
                return null;
            }
            return $error;
        } elseif ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch && $expr->dim !== null) {
            $type = $scope->getType($expr->var);
            $dimType = $scope->getType($expr->dim);
            $hasOffsetValue = $type->hasOffsetValueType($dimType);
            if (!$type->isOffsetAccessible()->yes()) {
                return $error;
            }
            if ($hasOffsetValue->no()) {
                return $error ?? \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Offset %s on %s %s does not exist.', $dimType->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value()), $type->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value()), $operatorDescription))->build();
            }
            if ($hasOffsetValue->maybe()) {
                return null;
            }
            // If offset is cannot be null, store this error message and see if one of the earlier offsets is.
            // E.g. $array['a']['b']['c'] ?? null; is a valid coalesce if a OR b or C might be null.
            if ($hasOffsetValue->yes()) {
                $error = $error ?? $this->generateError($type->getOffsetValueType($dimType), \sprintf('Offset %s on %s %s always exists and', $dimType->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value()), $type->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value()), $operatorDescription));
                if ($error !== null) {
                    return $this->check($expr->var, $scope, $operatorDescription, $error);
                }
            }
            // Has offset, it is nullable
            return null;
        } elseif ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch || $expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticPropertyFetch) {
            $propertyReflection = $this->propertyReflectionFinder->findPropertyReflectionFromNode($expr, $scope);
            if ($propertyReflection === null) {
                return null;
            }
            if (!$propertyReflection->isNative()) {
                return null;
            }
            $nativeType = $propertyReflection->getNativeType();
            if (!$nativeType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
                if (!$scope->isSpecified($expr)) {
                    return null;
                }
            }
            $propertyDescription = $this->propertyDescriptor->describeProperty($propertyReflection, $expr);
            $propertyType = $propertyReflection->getWritableType();
            $error = $error ?? $this->generateError($propertyReflection->getWritableType(), \sprintf('%s (%s) %s', $propertyDescription, $propertyType->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::typeOnly()), $operatorDescription));
            if ($error !== null) {
                if ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch) {
                    return $this->check($expr->var, $scope, $operatorDescription, $error);
                }
                if ($expr->class instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr) {
                    return $this->check($expr->class, $scope, $operatorDescription, $error);
                }
            }
            return $error;
        }
        return $error ?? $this->generateError($scope->getType($expr), \sprintf('Expression %s', $operatorDescription));
    }
    private function generateError(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, string $message) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleError
    {
        $nullType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType();
        if ($type->equals($nullType)) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s is always null.', $message))->build();
        }
        if ($type->isSuperTypeOf($nullType)->no()) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s is not nullable.', $message))->build();
        }
        return null;
    }
}
