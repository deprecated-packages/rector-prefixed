<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Properties;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PhpParser\Node\VarLikeIdentifier;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StaticType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ThisType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
class PropertyReflectionFinder
{
    /**
     * @param \PhpParser\Node\Expr\PropertyFetch|\PhpParser\Node\Expr\StaticPropertyFetch $propertyFetch
     * @param \PHPStan\Analyser\Scope $scope
     * @return FoundPropertyReflection[]
     */
    public function findPropertyReflectionsFromNode($propertyFetch, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if ($propertyFetch instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            if ($propertyFetch->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier) {
                $names = [$propertyFetch->name->name];
            } else {
                $names = \array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType $name) : string {
                    return $name->getValue();
                }, \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($propertyFetch->name)));
            }
            $reflections = [];
            $propertyHolderType = $scope->getType($propertyFetch->var);
            $fetchedOnThis = $propertyHolderType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ThisType && $scope->isInClass();
            foreach ($names as $name) {
                $reflection = $this->findPropertyReflection($propertyHolderType, $name, $propertyFetch->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr ? $scope->filterByTruthyValue(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical($propertyFetch->name, new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($name))) : $scope, $fetchedOnThis);
                if ($reflection === null) {
                    continue;
                }
                $reflections[] = $reflection;
            }
            return $reflections;
        }
        if ($propertyFetch->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            $propertyHolderType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($scope->resolveName($propertyFetch->class));
        } else {
            $propertyHolderType = $scope->getType($propertyFetch->class);
        }
        $fetchedOnThis = $propertyHolderType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ThisType && $scope->isInClass();
        if ($propertyFetch->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\VarLikeIdentifier) {
            $names = [$propertyFetch->name->name];
        } else {
            $names = \array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType $name) : string {
                return $name->getValue();
            }, \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($propertyFetch->name)));
        }
        $reflections = [];
        foreach ($names as $name) {
            $reflection = $this->findPropertyReflection($propertyHolderType, $name, $propertyFetch->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr ? $scope->filterByTruthyValue(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical($propertyFetch->name, new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($name))) : $scope, $fetchedOnThis);
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
    public function findPropertyReflectionFromNode($propertyFetch, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : ?\_PhpScoperb75b35f52b74\PHPStan\Rules\Properties\FoundPropertyReflection
    {
        if ($propertyFetch instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            if (!$propertyFetch->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier) {
                return null;
            }
            $propertyHolderType = $scope->getType($propertyFetch->var);
            $fetchedOnThis = $propertyHolderType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ThisType && $scope->isInClass();
            return $this->findPropertyReflection($propertyHolderType, $propertyFetch->name->name, $scope, $fetchedOnThis);
        }
        if (!$propertyFetch->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier) {
            return null;
        }
        if ($propertyFetch->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            $propertyHolderType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($scope->resolveName($propertyFetch->class));
        } else {
            $propertyHolderType = $scope->getType($propertyFetch->class);
        }
        $fetchedOnThis = $propertyHolderType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ThisType && $scope->isInClass();
        return $this->findPropertyReflection($propertyHolderType, $propertyFetch->name->name, $scope, $fetchedOnThis);
    }
    private function findPropertyReflection(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $propertyHolderType, string $propertyName, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, bool $fetchedOnThis) : ?\_PhpScoperb75b35f52b74\PHPStan\Rules\Properties\FoundPropertyReflection
    {
        $transformedPropertyHolderType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser::map($propertyHolderType, static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, callable $traverse) use($scope, $fetchedOnThis) : Type {
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StaticType) {
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
        return new \_PhpScoperb75b35f52b74\PHPStan\Rules\Properties\FoundPropertyReflection($originalProperty, $scope, $propertyName, $readableType, $writableType);
    }
    private function transformPropertyType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $propertyType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $transformedPropertyHolderType, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, bool $fetchedOnThis) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser::map($propertyType, static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $propertyType, callable $traverse) use($transformedPropertyHolderType, $scope, $fetchedOnThis) : Type {
            if ($propertyType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StaticType) {
                if ($fetchedOnThis && $scope->isInClass()) {
                    return $traverse($propertyType->changeBaseClass($scope->getClassReflection()));
                }
                return $traverse($transformedPropertyHolderType);
            }
            return $traverse($propertyType);
        });
    }
}
