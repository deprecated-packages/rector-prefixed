<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Properties;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\VarLikeIdentifier;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StaticType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ThisType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeTraverser;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils;
class PropertyReflectionFinder
{
    /**
     * @param \PhpParser\Node\Expr\PropertyFetch|\PhpParser\Node\Expr\StaticPropertyFetch $propertyFetch
     * @param \PHPStan\Analyser\Scope $scope
     * @return FoundPropertyReflection[]
     */
    public function findPropertyReflectionsFromNode($propertyFetch, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        if ($propertyFetch instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch) {
            if ($propertyFetch->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier) {
                $names = [$propertyFetch->name->name];
            } else {
                $names = \array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType $name) : string {
                    return $name->getValue();
                }, \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($propertyFetch->name)));
            }
            $reflections = [];
            $propertyHolderType = $scope->getType($propertyFetch->var);
            $fetchedOnThis = $propertyHolderType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ThisType && $scope->isInClass();
            foreach ($names as $name) {
                $reflection = $this->findPropertyReflection($propertyHolderType, $name, $propertyFetch->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr ? $scope->filterByTruthyValue(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical($propertyFetch->name, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($name))) : $scope, $fetchedOnThis);
                if ($reflection === null) {
                    continue;
                }
                $reflections[] = $reflection;
            }
            return $reflections;
        }
        if ($propertyFetch->class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
            $propertyHolderType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($scope->resolveName($propertyFetch->class));
        } else {
            $propertyHolderType = $scope->getType($propertyFetch->class);
        }
        $fetchedOnThis = $propertyHolderType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ThisType && $scope->isInClass();
        if ($propertyFetch->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\VarLikeIdentifier) {
            $names = [$propertyFetch->name->name];
        } else {
            $names = \array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType $name) : string {
                return $name->getValue();
            }, \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($propertyFetch->name)));
        }
        $reflections = [];
        foreach ($names as $name) {
            $reflection = $this->findPropertyReflection($propertyHolderType, $name, $propertyFetch->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr ? $scope->filterByTruthyValue(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical($propertyFetch->name, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($name))) : $scope, $fetchedOnThis);
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
    public function findPropertyReflectionFromNode($propertyFetch, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : ?\_PhpScoper0a2ac50786fa\PHPStan\Rules\Properties\FoundPropertyReflection
    {
        if ($propertyFetch instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch) {
            if (!$propertyFetch->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier) {
                return null;
            }
            $propertyHolderType = $scope->getType($propertyFetch->var);
            $fetchedOnThis = $propertyHolderType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ThisType && $scope->isInClass();
            return $this->findPropertyReflection($propertyHolderType, $propertyFetch->name->name, $scope, $fetchedOnThis);
        }
        if (!$propertyFetch->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier) {
            return null;
        }
        if ($propertyFetch->class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
            $propertyHolderType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($scope->resolveName($propertyFetch->class));
        } else {
            $propertyHolderType = $scope->getType($propertyFetch->class);
        }
        $fetchedOnThis = $propertyHolderType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ThisType && $scope->isInClass();
        return $this->findPropertyReflection($propertyHolderType, $propertyFetch->name->name, $scope, $fetchedOnThis);
    }
    private function findPropertyReflection(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $propertyHolderType, string $propertyName, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, bool $fetchedOnThis) : ?\_PhpScoper0a2ac50786fa\PHPStan\Rules\Properties\FoundPropertyReflection
    {
        $transformedPropertyHolderType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeTraverser::map($propertyHolderType, static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, callable $traverse) use($scope, $fetchedOnThis) : Type {
            if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\StaticType) {
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
        return new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Properties\FoundPropertyReflection($originalProperty, $scope, $propertyName, $readableType, $writableType);
    }
    private function transformPropertyType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $propertyType, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $transformedPropertyHolderType, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, bool $fetchedOnThis) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeTraverser::map($propertyType, static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $propertyType, callable $traverse) use($transformedPropertyHolderType, $scope, $fetchedOnThis) : Type {
            if ($propertyType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\StaticType) {
                if ($fetchedOnThis && $scope->isInClass()) {
                    return $traverse($propertyType->changeBaseClass($scope->getClassReflection()));
                }
                return $traverse($transformedPropertyHolderType);
            }
            return $traverse($propertyType);
        });
    }
}
