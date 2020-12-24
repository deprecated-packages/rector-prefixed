<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Properties;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\VarLikeIdentifier;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\StaticType;
use _PhpScopere8e811afab72\PHPStan\Type\ThisType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeTraverser;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
class PropertyReflectionFinder
{
    /**
     * @param \PhpParser\Node\Expr\PropertyFetch|\PhpParser\Node\Expr\StaticPropertyFetch $propertyFetch
     * @param \PHPStan\Analyser\Scope $scope
     * @return FoundPropertyReflection[]
     */
    public function findPropertyReflectionsFromNode($propertyFetch, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if ($propertyFetch instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            if ($propertyFetch->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier) {
                $names = [$propertyFetch->name->name];
            } else {
                $names = \array_map(static function (\_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType $name) : string {
                    return $name->getValue();
                }, \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($propertyFetch->name)));
            }
            $reflections = [];
            $propertyHolderType = $scope->getType($propertyFetch->var);
            $fetchedOnThis = $propertyHolderType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ThisType && $scope->isInClass();
            foreach ($names as $name) {
                $reflection = $this->findPropertyReflection($propertyHolderType, $name, $propertyFetch->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr ? $scope->filterByTruthyValue(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical($propertyFetch->name, new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($name))) : $scope, $fetchedOnThis);
                if ($reflection === null) {
                    continue;
                }
                $reflections[] = $reflection;
            }
            return $reflections;
        }
        if ($propertyFetch->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            $propertyHolderType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($scope->resolveName($propertyFetch->class));
        } else {
            $propertyHolderType = $scope->getType($propertyFetch->class);
        }
        $fetchedOnThis = $propertyHolderType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ThisType && $scope->isInClass();
        if ($propertyFetch->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\VarLikeIdentifier) {
            $names = [$propertyFetch->name->name];
        } else {
            $names = \array_map(static function (\_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType $name) : string {
                return $name->getValue();
            }, \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($propertyFetch->name)));
        }
        $reflections = [];
        foreach ($names as $name) {
            $reflection = $this->findPropertyReflection($propertyHolderType, $name, $propertyFetch->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr ? $scope->filterByTruthyValue(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical($propertyFetch->name, new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($name))) : $scope, $fetchedOnThis);
            if ($reflection === null) {
                continue;
            }
            $reflections[] = $reflection;
        }
        return $reflections;
    }
    /**
     * @param \PhpParser\Node\Expr\PropertyFetch|\PhpParser\Node\Expr\StaticPropertyFetch $propertyFetch
     * @param \PHPStan\Analyser\Scope $scope
     * @return FoundPropertyReflection|null
     */
    public function findPropertyReflectionFromNode($propertyFetch, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : ?\_PhpScopere8e811afab72\PHPStan\Rules\Properties\FoundPropertyReflection
    {
        if ($propertyFetch instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            if (!$propertyFetch->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier) {
                return null;
            }
            $propertyHolderType = $scope->getType($propertyFetch->var);
            $fetchedOnThis = $propertyHolderType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ThisType && $scope->isInClass();
            return $this->findPropertyReflection($propertyHolderType, $propertyFetch->name->name, $scope, $fetchedOnThis);
        }
        if (!$propertyFetch->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier) {
            return null;
        }
        if ($propertyFetch->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            $propertyHolderType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($scope->resolveName($propertyFetch->class));
        } else {
            $propertyHolderType = $scope->getType($propertyFetch->class);
        }
        $fetchedOnThis = $propertyHolderType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ThisType && $scope->isInClass();
        return $this->findPropertyReflection($propertyHolderType, $propertyFetch->name->name, $scope, $fetchedOnThis);
    }
    private function findPropertyReflection(\_PhpScopere8e811afab72\PHPStan\Type\Type $propertyHolderType, string $propertyName, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, bool $fetchedOnThis) : ?\_PhpScopere8e811afab72\PHPStan\Rules\Properties\FoundPropertyReflection
    {
        $transformedPropertyHolderType = \_PhpScopere8e811afab72\PHPStan\Type\TypeTraverser::map($propertyHolderType, static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type, callable $traverse) use($scope, $fetchedOnThis) : Type {
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\StaticType) {
                if ($fetchedOnThis && $scope->isInClass()) {
                    return $traverse($type->changeBaseClass($scope->getClassReflection()));
                }
                if ($scope->isInClass()) {
                    return $traverse($type->changeBaseClass($scope->getClassReflection())->getStaticObjectType());
                }
            }
            return $traverse($type);
        });
        if (!$transformedPropertyHolderType->hasProperty($propertyName)->yes()) {
            return null;
        }
        $originalProperty = $transformedPropertyHolderType->getProperty($propertyName, $scope);
        $readableType = $this->transformPropertyType($originalProperty->getReadableType(), $transformedPropertyHolderType, $scope, $fetchedOnThis);
        $writableType = $this->transformPropertyType($originalProperty->getWritableType(), $transformedPropertyHolderType, $scope, $fetchedOnThis);
        return new \_PhpScopere8e811afab72\PHPStan\Rules\Properties\FoundPropertyReflection($originalProperty, $scope, $propertyName, $readableType, $writableType);
    }
    private function transformPropertyType(\_PhpScopere8e811afab72\PHPStan\Type\Type $propertyType, \_PhpScopere8e811afab72\PHPStan\Type\Type $transformedPropertyHolderType, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, bool $fetchedOnThis) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeTraverser::map($propertyType, static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $propertyType, callable $traverse) use($transformedPropertyHolderType, $scope, $fetchedOnThis) : Type {
            if ($propertyType instanceof \_PhpScopere8e811afab72\PHPStan\Type\StaticType) {
                if ($fetchedOnThis && $scope->isInClass()) {
                    return $traverse($propertyType->changeBaseClass($scope->getClassReflection()));
                }
                return $traverse($transformedPropertyHolderType);
            }
            return $traverse($propertyType);
        });
    }
}
