<?php

declare(strict_types=1);

namespace Rector\Core\NodeManipulator;

use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\TraitUse;
use PHPStan\Type\Type;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\PostRector\ValueObject\PropertyMetadata;

final class ClassInsertManipulator
{
    /**
     * @var array<class-string<Stmt>>
     */
    const BEFORE_TRAIT_TYPES = [TraitUse::class, Property::class, ClassMethod::class];

    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var NodeFactory
     */
    private $nodeFactory;

    public function __construct(NodeFactory $nodeFactory, NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeFactory = $nodeFactory;
    }

    /**
     * @param ClassMethod|Property|ClassConst|ClassMethod $stmt
     * @return void
     */
    public function addAsFirstMethod(Class_ $class, Stmt $stmt)
    {
        if ($this->isSuccessToInsertBeforeFirstMethod($class, $stmt)) {
            return;
        }
        if ($this->isSuccessToInsertAfterLastProperty($class, $stmt)) {
            return;
        }

        $class->stmts[] = $stmt;
    }

    /**
     * @return void
     */
    public function addConstantToClass(Class_ $class, string $constantName, ClassConst $classConst)
    {
        if ($this->hasClassConstant($class, $constantName)) {
            return;
        }

        $this->addAsFirstMethod($class, $classConst);
    }

    /**
     * @param Property[] $properties
     * @return void
     */
    public function addPropertiesToClass(Class_ $class, array $properties)
    {
        foreach ($properties as $property) {
            $this->addAsFirstMethod($class, $property);
        }
    }

    /**
     * @internal Use PropertyAdder service instead
     * @param \PHPStan\Type\Type|null $type
     * @return void
     */
    public function addPropertyToClass(Class_ $class, string $name, $type)
    {
        $existingProperty = $class->getProperty($name);
        if ($existingProperty instanceof Property) {
            return;
        }

        $property = $this->nodeFactory->createPrivatePropertyFromNameAndType($name, $type);
        $this->addAsFirstMethod($class, $property);
    }

    /**
     * @return void
     */
    public function addInjectPropertyToClass(Class_ $class, PropertyMetadata $propertyMetadata)
    {
        $existingProperty = $class->getProperty($propertyMetadata->getName());
        if ($existingProperty instanceof Property) {
            return;
        }

        $property = $this->nodeFactory->createPublicInjectPropertyFromNameAndType(
            $propertyMetadata->getName(),
            $propertyMetadata->getType()
        );
        $this->addAsFirstMethod($class, $property);
    }

    /**
     * @return void
     */
    public function addAsFirstTrait(Class_ $class, string $traitName)
    {
        $traitUse = new TraitUse([new FullyQualified($traitName)]);
        $this->addTraitUse($class, $traitUse);
    }

    /**
     * @param Stmt[] $nodes
     * @return Stmt[]
     */
    public function insertBefore(array $nodes, Stmt $stmt, int $key): array
    {
        array_splice($nodes, $key, 0, [$stmt]);

        return $nodes;
    }

    private function isSuccessToInsertBeforeFirstMethod(Class_ $class, Stmt $stmt): bool
    {
        foreach ($class->stmts as $key => $classStmt) {
            if (! $classStmt instanceof ClassMethod) {
                continue;
            }

            $class->stmts = $this->insertBefore($class->stmts, $stmt, $key);

            return true;
        }

        return false;
    }

    private function isSuccessToInsertAfterLastProperty(Class_ $class, Stmt $stmt): bool
    {
        $previousElement = null;
        foreach ($class->stmts as $key => $classStmt) {
            if ($previousElement instanceof Property && ! $classStmt instanceof Property) {
                $class->stmts = $this->insertBefore($class->stmts, $stmt, $key);

                return true;
            }

            $previousElement = $classStmt;
        }

        return false;
    }

    private function hasClassConstant(Class_ $class, string $constantName): bool
    {
        foreach ($class->getConstants() as $classConst) {
            if ($this->nodeNameResolver->isName($classConst, $constantName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return void
     */
    private function addTraitUse(Class_ $class, TraitUse $traitUse)
    {
        foreach (self::BEFORE_TRAIT_TYPES as $type) {
            foreach ($class->stmts as $key => $classStmt) {
                if (! $classStmt instanceof $type) {
                    continue;
                }

                $class->stmts = $this->insertBefore($class->stmts, $traitUse, $key);

                return;
            }
        }

        $class->stmts[] = $traitUse;
    }
}
