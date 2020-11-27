<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Node\Manipulator;

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
final class ClassInsertManipulator
{
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
     */
    public function addAsFirstMethod(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Stmt $stmt) : void
    {
        if ($this->tryInsertBeforeFirstMethod($class, $stmt)) {
            return;
        }
        if ($this->tryInsertAfterLastProperty($class, $stmt)) {
            return;
        }
        $class->stmts[] = $stmt;
    }
    public function addConstantToClass(\PhpParser\Node\Stmt\Class_ $class, string $constantName, \PhpParser\Node\Stmt\ClassConst $classConst) : void
    {
        if ($this->hasClassConstant($class, $constantName)) {
            return;
        }
        $this->addAsFirstMethod($class, $classConst);
    }
    public function addPropertyToClass(\PhpParser\Node\Stmt\Class_ $class, string $name, ?\PHPStan\Type\Type $type) : void
    {
        if ($this->hasClassProperty($class, $name)) {
            return;
        }
        $property = $this->nodeFactory->createPrivatePropertyFromNameAndType($name, $type);
        $this->addAsFirstMethod($class, $property);
    }
    public function addInjectPropertyToClass(\PhpParser\Node\Stmt\Class_ $class, string $name, ?\PHPStan\Type\Type $type) : void
    {
        if ($this->hasClassProperty($class, $name)) {
            return;
        }
        $propertyNode = $this->nodeFactory->createPublicInjectPropertyFromNameAndType($name, $type);
        $this->addAsFirstMethod($class, $propertyNode);
    }
    public function addAsFirstTrait(\PhpParser\Node\Stmt\Class_ $class, string $traitName) : void
    {
        $traitUse = new \PhpParser\Node\Stmt\TraitUse([new \PhpParser\Node\Name\FullyQualified($traitName)]);
        $this->addStatementToClassBeforeTypes($class, $traitUse, [\PhpParser\Node\Stmt\TraitUse::class, \PhpParser\Node\Stmt\Property::class, \PhpParser\Node\Stmt\ClassMethod::class]);
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
    private function tryInsertBeforeFirstMethod(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Stmt $stmt) : bool
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
    private function tryInsertAfterLastProperty(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Stmt $stmt) : bool
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
     * Waits on https://github.com/nikic/PHP-Parser/pull/646
     */
    private function hasClassProperty(\PhpParser\Node\Stmt\Class_ $class, string $name) : bool
    {
        foreach ($class->getProperties() as $property) {
            if (!$this->nodeNameResolver->isName($property, $name)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    /**
     * @param string[] $types
     */
    private function addStatementToClassBeforeTypes(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Stmt $stmt, array $types) : void
    {
        foreach ($types as $type) {
            foreach ($class->stmts as $key => $classStmt) {
                if (!$classStmt instanceof $type) {
                    continue;
                }
                $class->stmts = $this->insertBefore($class->stmts, $stmt, $key);
                return;
            }
        }
        $class->stmts[] = $stmt;
    }
}
