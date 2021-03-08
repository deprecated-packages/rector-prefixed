<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeAnalyzer;

use PHPStan\Type\CallableType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
final class ObjectTypeComparator
{
    /**
     * E.g. current E, new type A, E extends A → true
     * Also for closure/callable, iterable/Traversable/Iterator/Generator
     */
    public function isCurrentObjectTypeSubType(\PHPStan\Type\Type $currentType, \PHPStan\Type\Type $newType) : bool
    {
        if ($this->isBothCallable($currentType, $newType)) {
            return \true;
        }
        if ($this->isBothIterableIteratorGeneratorTraversable($currentType, $newType)) {
            return \true;
        }
        if (!$currentType instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        if (!$newType instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        return \is_a($currentType->getClassName(), $newType->getClassName(), \true);
    }
    private function isClosure(\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof \PHPStan\Type\ObjectType && $type->getClassName() === 'Closure';
    }
    private function isBothCallable(\PHPStan\Type\Type $currentType, \PHPStan\Type\Type $newType) : bool
    {
        if ($currentType instanceof \PHPStan\Type\CallableType && $this->isClosure($newType)) {
            return \true;
        }
        return $newType instanceof \PHPStan\Type\CallableType && $this->isClosure($currentType);
    }
    private function isBothIterableIteratorGeneratorTraversable(\PHPStan\Type\Type $currentType, \PHPStan\Type\Type $newType) : bool
    {
        if (!$currentType instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        if (!$newType instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        if ($currentType->getClassName() === 'iterable' && $this->isTraversableGeneratorIterator($newType)) {
            return \true;
        }
        if ($newType->getClassName() !== 'iterable') {
            return \false;
        }
        return $this->isTraversableGeneratorIterator($currentType);
    }
    private function isTraversableGeneratorIterator(\PHPStan\Type\ObjectType $objectType) : bool
    {
        return \in_array($objectType->getClassName(), ['Traversable', 'Generator', 'Iterator'], \true);
    }
}
