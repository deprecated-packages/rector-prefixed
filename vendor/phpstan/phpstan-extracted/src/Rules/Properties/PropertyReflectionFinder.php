<?php

declare (strict_types=1);
namespace PHPStan\Rules\Properties;

use PhpParser\Node\Expr;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\VarLikeIdentifier;
use PHPStan\Analyser\Scope;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StaticType;
use PHPStan\Type\ThisType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeTraverser;
use PHPStan\Type\TypeUtils;
class PropertyReflectionFinder
{
    /**
     * @param \PhpParser\Node\Expr\PropertyFetch|\PhpParser\Node\Expr\StaticPropertyFetch $propertyFetch
     * @param \PHPStan\Analyser\Scope $scope
     * @return FoundPropertyReflection[]
     */
    public function findPropertyReflectionsFromNode($propertyFetch, \PHPStan\Analyser\Scope $scope) : array
    {
        if ($propertyFetch instanceof \PhpParser\Node\Expr\PropertyFetch) {
            if ($propertyFetch->name instanceof \PhpParser\Node\Identifier) {
                $names = [$propertyFetch->name->name];
            } else {
                $names = \array_map(static function (\PHPStan\Type\Constant\ConstantStringType $name) : string {
                    return $name->getValue();
                }, \PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($propertyFetch->name)));
            }
            $reflections = [];
            $propertyHolderType = $scope->getType($propertyFetch->var);
            $fetchedOnThis = $propertyHolderType instanceof \PHPStan\Type\ThisType && $scope->isInClass();
            foreach ($names as $name) {
                $reflection = $this->findPropertyReflection($propertyHolderType, $name, $propertyFetch->name instanceof \PhpParser\Node\Expr ? $scope->filterByTruthyValue(new \PhpParser\Node\Expr\BinaryOp\Identical($propertyFetch->name, new \PhpParser\Node\Scalar\String_($name))) : $scope, $fetchedOnThis);
                if ($reflection === null) {
                    continue;
                }
                $reflections[] = $reflection;
            }
            return $reflections;
        }
        if ($propertyFetch->class instanceof \PhpParser\Node\Name) {
            $propertyHolderType = new \PHPStan\Type\ObjectType($scope->resolveName($propertyFetch->class));
        } else {
            $propertyHolderType = $scope->getType($propertyFetch->class);
        }
        $fetchedOnThis = $propertyHolderType instanceof \PHPStan\Type\ThisType && $scope->isInClass();
        if ($propertyFetch->name instanceof \PhpParser\Node\VarLikeIdentifier) {
            $names = [$propertyFetch->name->name];
        } else {
            $names = \array_map(static function (\PHPStan\Type\Constant\ConstantStringType $name) : string {
                return $name->getValue();
            }, \PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($propertyFetch->name)));
        }
        $reflections = [];
        foreach ($names as $name) {
            $reflection = $this->findPropertyReflection($propertyHolderType, $name, $propertyFetch->name instanceof \PhpParser\Node\Expr ? $scope->filterByTruthyValue(new \PhpParser\Node\Expr\BinaryOp\Identical($propertyFetch->name, new \PhpParser\Node\Scalar\String_($name))) : $scope, $fetchedOnThis);
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
    public function findPropertyReflectionFromNode($propertyFetch, \PHPStan\Analyser\Scope $scope) : ?\PHPStan\Rules\Properties\FoundPropertyReflection
    {
        if ($propertyFetch instanceof \PhpParser\Node\Expr\PropertyFetch) {
            if (!$propertyFetch->name instanceof \PhpParser\Node\Identifier) {
                return null;
            }
            $propertyHolderType = $scope->getType($propertyFetch->var);
            $fetchedOnThis = $propertyHolderType instanceof \PHPStan\Type\ThisType && $scope->isInClass();
            return $this->findPropertyReflection($propertyHolderType, $propertyFetch->name->name, $scope, $fetchedOnThis);
        }
        if (!$propertyFetch->name instanceof \PhpParser\Node\Identifier) {
            return null;
        }
        if ($propertyFetch->class instanceof \PhpParser\Node\Name) {
            $propertyHolderType = new \PHPStan\Type\ObjectType($scope->resolveName($propertyFetch->class));
        } else {
            $propertyHolderType = $scope->getType($propertyFetch->class);
        }
        $fetchedOnThis = $propertyHolderType instanceof \PHPStan\Type\ThisType && $scope->isInClass();
        return $this->findPropertyReflection($propertyHolderType, $propertyFetch->name->name, $scope, $fetchedOnThis);
    }
    private function findPropertyReflection(\PHPStan\Type\Type $propertyHolderType, string $propertyName, \PHPStan\Analyser\Scope $scope, bool $fetchedOnThis) : ?\PHPStan\Rules\Properties\FoundPropertyReflection
    {
        $transformedPropertyHolderType = \PHPStan\Type\TypeTraverser::map($propertyHolderType, static function (\PHPStan\Type\Type $type, callable $traverse) use($scope, $fetchedOnThis) : Type {
            if ($type instanceof \PHPStan\Type\StaticType) {
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
        return new \PHPStan\Rules\Properties\FoundPropertyReflection($originalProperty, $scope, $propertyName, $readableType, $writableType);
    }
    private function transformPropertyType(\PHPStan\Type\Type $propertyType, \PHPStan\Type\Type $transformedPropertyHolderType, \PHPStan\Analyser\Scope $scope, bool $fetchedOnThis) : \PHPStan\Type\Type
    {
        return \PHPStan\Type\TypeTraverser::map($propertyType, static function (\PHPStan\Type\Type $propertyType, callable $traverse) use($transformedPropertyHolderType, $scope, $fetchedOnThis) : Type {
            if ($propertyType instanceof \PHPStan\Type\StaticType) {
                if ($fetchedOnThis && $scope->isInClass()) {
                    return $traverse($propertyType->changeBaseClass($scope->getClassReflection()));
                }
                return $traverse($transformedPropertyHolderType);
            }
            return $traverse($propertyType);
        });
    }
}
