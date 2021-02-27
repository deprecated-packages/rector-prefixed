<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeAnalyzer;

use RectorPrefix20210227\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Stmt;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\Generic\GenericClassStringType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
use Rector\NodeTypeResolver\NodeTypeCorrector\GenericClassStringTypeCorrector;
final class UnionTypeCommonTypeNarrower
{
    /**
     * Key = the winner
     * Array = the group of types matched
     *
     * @var array<class-string<Node|\PHPStan\PhpDocParser\Ast\Node>, array<class-string<Node|\PHPStan\PhpDocParser\Ast\Node>>>
     */
    private const PRIORITY_TYPES = [\PhpParser\Node\Expr\BinaryOp::class => [\PhpParser\Node\Expr\BinaryOp::class, \PhpParser\Node\Expr::class], \PhpParser\Node\Expr::class => [\PhpParser\Node::class, \PhpParser\Node\Expr::class], \PhpParser\Node\Stmt::class => [\PhpParser\Node::class, \PhpParser\Node\Stmt::class], 'PHPStan\\PhpDocParser\\Ast\\PhpDoc\\PhpDocTagValueNode' => ['PHPStan\\PhpDocParser\\Ast\\PhpDoc\\PhpDocTagValueNode', 'PHPStan\\PhpDocParser\\Ast\\Node']];
    /**
     * @var GenericClassStringTypeCorrector
     */
    private $genericClassStringTypeCorrector;
    public function __construct(\Rector\NodeTypeResolver\NodeTypeCorrector\GenericClassStringTypeCorrector $genericClassStringTypeCorrector)
    {
        $this->genericClassStringTypeCorrector = $genericClassStringTypeCorrector;
    }
    public function narrowToSharedObjectType(\PHPStan\Type\UnionType $unionType) : ?\PHPStan\Type\ObjectType
    {
        $sharedTypes = $this->narrowToSharedTypes($unionType);
        if ($sharedTypes !== []) {
            foreach (self::PRIORITY_TYPES as $winningType => $groupTypes) {
                if (\array_intersect($groupTypes, $sharedTypes) === $groupTypes) {
                    return new \PHPStan\Type\ObjectType($winningType);
                }
            }
            $firstSharedType = $sharedTypes[0];
            return new \PHPStan\Type\ObjectType($firstSharedType);
        }
        return null;
    }
    /**
     * @return GenericClassStringType|UnionType
     */
    public function narrowToGenericClassStringType(\PHPStan\Type\UnionType $unionType) : \PHPStan\Type\Type
    {
        $availableTypes = [];
        foreach ($unionType->getTypes() as $unionedType) {
            if ($unionedType instanceof \PHPStan\Type\Constant\ConstantStringType) {
                $unionedType = $this->genericClassStringTypeCorrector->correct($unionedType);
            }
            if (!$unionedType instanceof \PHPStan\Type\Generic\GenericClassStringType) {
                return $unionType;
            }
            if ($unionedType->getGenericType() instanceof \PHPStan\Type\TypeWithClassName) {
                $availableTypes[] = $this->resolveClassParentClassesAndInterfaces($unionedType->getGenericType());
            }
        }
        $genericClassStringType = $this->createGenericClassStringType($availableTypes);
        if ($genericClassStringType instanceof \PHPStan\Type\Generic\GenericClassStringType) {
            return $genericClassStringType;
        }
        return $unionType;
    }
    /**
     * @return string[]
     */
    private function narrowToSharedTypes(\PHPStan\Type\UnionType $unionType) : array
    {
        $availableTypes = [];
        foreach ($unionType->getTypes() as $unionedType) {
            if (!$unionedType instanceof \PHPStan\Type\TypeWithClassName) {
                return [];
            }
            $availableTypes[] = $this->resolveClassParentClassesAndInterfaces($unionedType);
        }
        return $this->narrowAvailableTypes($availableTypes);
    }
    /**
     * @return string[]
     */
    private function resolveClassParentClassesAndInterfaces(\PHPStan\Type\TypeWithClassName $typeWithClassName) : array
    {
        $parentClasses = \class_parents($typeWithClassName->getClassName());
        if ($parentClasses === \false) {
            $parentClasses = [];
        }
        $implementedInterfaces = \class_implements($typeWithClassName->getClassName());
        if ($implementedInterfaces === \false) {
            $implementedInterfaces = [];
        }
        $implementedInterfaces = $this->filterOutNativeInterfaces($implementedInterfaces);
        // put earliest interfaces first
        $implementedInterfaces = \array_reverse($implementedInterfaces);
        $classParentClassesAndInterfaces = \array_merge($implementedInterfaces, $parentClasses);
        return \array_unique($classParentClassesAndInterfaces);
    }
    /**
     * @param class-string[] $interfaces
     * @return class-string[]
     */
    private function filterOutNativeInterfaces(array $interfaces) : array
    {
        foreach ($interfaces as $key => $implementedInterface) {
            // remove native interfaces
            if (\RectorPrefix20210227\Nette\Utils\Strings::contains($implementedInterface, '\\')) {
                continue;
            }
            unset($interfaces[$key]);
        }
        return $interfaces;
    }
    /**
     * @param string[][] $availableTypes
     * @return string[]
     */
    private function narrowAvailableTypes(array $availableTypes) : array
    {
        /** @var string[] $sharedTypes */
        $sharedTypes = \array_intersect(...$availableTypes);
        return \array_values($sharedTypes);
    }
    /**
     * @param string[][] $availableTypes
     */
    private function createGenericClassStringType(array $availableTypes) : ?\PHPStan\Type\Generic\GenericClassStringType
    {
        $sharedTypes = $this->narrowAvailableTypes($availableTypes);
        if ($sharedTypes !== []) {
            foreach (self::PRIORITY_TYPES as $winningType => $groupTypes) {
                if (\array_intersect($groupTypes, $sharedTypes) === $groupTypes) {
                    return new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType($winningType));
                }
            }
            $firstSharedType = $sharedTypes[0];
            return new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType($firstSharedType));
        }
        return null;
    }
}
