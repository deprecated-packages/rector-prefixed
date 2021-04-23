<?php

declare (strict_types=1);
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
    const BEFORE_TRAIT_TYPES = [\PhpParser\Node\Stmt\TraitUse::class, \PhpParser\Node\Stmt\Property::class, \PhpParser\Node\Stmt\ClassMethod::class];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeFactory = $nodeFactory;
    }
    /**
     * @param ClassMethod|Property|ClassConst|ClassMethod $stmt
     * @return void
     */
    public function addAsFirstMethod(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Stmt $stmt)
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
    public function addConstantToClass(\PhpParser\Node\Stmt\Class_ $class, string $constantName, \PhpParser\Node\Stmt\ClassConst $classConst)
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
    public function addPropertiesToClass(\PhpParser\Node\Stmt\Class_ $class, array $properties)
    {
        foreach ($properties as $property) {
            $this->addAsFirstMethod($class, $property);
        }
    }
    /**
     * @internal Use PropertyAdder service instead
     * @return void
     */
    public function addPropertyToClass(\PhpParser\Node\Stmt\Class_ $class, string $name, ?\PHPStan\Type\Type $type)
    {
        $existingProperty = $class->getProperty($name);
        if ($existingProperty instanceof \PhpParser\Node\Stmt\Property) {
            return;
        }
        $property = $this->nodeFactory->createPrivatePropertyFromNameAndType($name, $type);
        $this->addAsFirstMethod($class, $property);
    }
    /**
     * @return void
     */
    public function addInjectPropertyToClass(\PhpParser\Node\Stmt\Class_ $class, \Rector\PostRector\ValueObject\PropertyMetadata $propertyMetadata)
    {
        $existingProperty = $class->getProperty($propertyMetadata->getName());
        if ($existingProperty instanceof \PhpParser\Node\Stmt\Property) {
            return;
        }
        $property = $this->nodeFactory->createPublicInjectPropertyFromNameAndType($propertyMetadata->getName(), $propertyMetadata->getType());
        $this->addAsFirstMethod($class, $property);
    }
    /**
     * @return void
     */
    public function addAsFirstTrait(\PhpParser\Node\Stmt\Class_ $class, string $traitName)
    {
        $traitUse = new \PhpParser\Node\Stmt\TraitUse([new \PhpParser\Node\Name\FullyQualified($traitName)]);
        $this->addTraitUse($class, $traitUse);
    }
    /**
     * @param Stmt[] $nodes
     * @return Stmt[]
     */
    public function insertBefore(array $nodes, \PhpParser\Node\Stmt $stmt, int $key) : array
    {
        \array_splice($nodes, $key, 0, [$stmt]);
        return $nodes;
    }
    private function isSuccessToInsertBeforeFirstMethod(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Stmt $stmt) : bool
    {
        foreach ($class->stmts as $key => $classStmt) {
            if (!$classStmt instanceof \PhpParser\Node\Stmt\ClassMethod) {
                continue;
            }
            $class->stmts = $this->insertBefore($class->stmts, $stmt, $key);
            return \true;
        }
        return \false;
    }
    private function isSuccessToInsertAfterLastProperty(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Stmt $stmt) : bool
    {
        $previousElement = null;
        foreach ($class->stmts as $key => $classStmt) {
            if ($previousElement instanceof \PhpParser\Node\Stmt\Property && !$classStmt instanceof \PhpParser\Node\Stmt\Property) {
                $class->stmts = $this->insertBefore($class->stmts, $stmt, $key);
                return \true;
            }
            $previousElement = $classStmt;
        }
        return \false;
    }
    private function hasClassConstant(\PhpParser\Node\Stmt\Class_ $class, string $constantName) : bool
    {
        foreach ($class->getConstants() as $classConst) {
            if ($this->nodeNameResolver->isName($classConst, $constantName)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @return void
     */
    private function addTraitUse(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Stmt\TraitUse $traitUse)
    {
        foreach (self::BEFORE_TRAIT_TYPES as $type) {
            foreach ($class->stmts as $key => $classStmt) {
                if (!$classStmt instanceof $type) {
                    continue;
                }
                $class->stmts = $this->insertBefore($class->stmts, $traitUse, $key);
                return;
            }
        }
        $class->stmts[] = $traitUse;
    }
}
