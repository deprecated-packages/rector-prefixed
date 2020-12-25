<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Node\Manipulator;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PHPStan\Type\Type;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionClass;
use ReflectionProperty;
final class ClassDependencyManipulator
{
    /**
     * @var ClassMethodAssignManipulator
     */
    private $classMethodAssignManipulator;
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var ChildAndParentClassManipulator
     */
    private $childAndParentClassManipulator;
    /**
     * @var StmtsManipulator
     */
    private $stmtsManipulator;
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\Rector\Core\PhpParser\Node\Manipulator\ChildAndParentClassManipulator $childAndParentClassManipulator, \Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator, \Rector\Core\PhpParser\Node\Manipulator\ClassMethodAssignManipulator $classMethodAssignManipulator, \Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\Core\PhpParser\Node\Manipulator\StmtsManipulator $stmtsManipulator)
    {
        $this->classMethodAssignManipulator = $classMethodAssignManipulator;
        $this->nodeFactory = $nodeFactory;
        $this->childAndParentClassManipulator = $childAndParentClassManipulator;
        $this->stmtsManipulator = $stmtsManipulator;
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function addConstructorDependency(\PhpParser\Node\Stmt\Class_ $class, string $name, ?\PHPStan\Type\Type $type) : void
    {
        if ($this->isPropertyAlreadyAvailableInTheClassOrItsParents($class, $name)) {
            return;
        }
        $this->classInsertManipulator->addPropertyToClass($class, $name, $type);
        $assign = $this->nodeFactory->createPropertyAssignment($name);
        $this->addConstructorDependencyWithCustomAssign($class, $name, $type, $assign);
    }
    public function addConstructorDependencyWithCustomAssign(\PhpParser\Node\Stmt\Class_ $class, string $name, ?\PHPStan\Type\Type $type, \PhpParser\Node\Expr\Assign $assign) : void
    {
        /** @var ClassMethod|null $constructorMethod */
        $constructorMethod = $class->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructorMethod !== null) {
            $this->classMethodAssignManipulator->addParameterAndAssignToMethod($constructorMethod, $name, $type, $assign);
            return;
        }
        $constructorMethod = $this->nodeFactory->createPublicMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $this->classMethodAssignManipulator->addParameterAndAssignToMethod($constructorMethod, $name, $type, $assign);
        $this->childAndParentClassManipulator->completeParentConstructor($class, $constructorMethod);
        $this->classInsertManipulator->addAsFirstMethod($class, $constructorMethod);
        $this->childAndParentClassManipulator->completeChildConstructors($class, $constructorMethod);
    }
    /**
     * @param Stmt[] $stmts
     */
    public function addStmtsToConstructorIfNotThereYet(\PhpParser\Node\Stmt\Class_ $class, array $stmts) : void
    {
        $classMethod = $class->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($classMethod === null) {
            $classMethod = $this->nodeFactory->createPublicMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
            // keep parent constructor call
            if ($this->hasClassParentClassMethod($class, \Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
                $classMethod->stmts[] = $this->createParentClassMethodCall(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
            }
            $classMethod->stmts = \array_merge((array) $classMethod->stmts, $stmts);
            $class->stmts = \array_merge($class->stmts, [$classMethod]);
            return;
        }
        $stmts = $this->stmtsManipulator->filterOutExistingStmts($classMethod, $stmts);
        // all stmts are already there → skip
        if ($stmts === []) {
            return;
        }
        $classMethod->stmts = \array_merge($stmts, (array) $classMethod->stmts);
    }
    public function addInjectProperty(\PhpParser\Node\Stmt\Class_ $class, string $propertyName, ?\PHPStan\Type\Type $propertyType) : void
    {
        if ($this->isPropertyAlreadyAvailableInTheClassOrItsParents($class, $propertyName)) {
            return;
        }
        $this->classInsertManipulator->addInjectPropertyToClass($class, $propertyName, $propertyType);
    }
    private function isPropertyAlreadyAvailableInTheClassOrItsParents(\PhpParser\Node\Stmt\Class_ $class, string $propertyName) : bool
    {
        $className = $class->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return \false;
        }
        if (!\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($className)) {
            return \false;
        }
        $availablePropertyReflections = $this->getParentClassPublicAndProtectedPropertyReflections($className);
        foreach ($availablePropertyReflections as $availablePropertyReflection) {
            if ($availablePropertyReflection->getName() !== $propertyName) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    private function hasClassParentClassMethod(\PhpParser\Node\Stmt\Class_ $class, string $methodName) : bool
    {
        $parentClassName = $class->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName === null) {
            return \false;
        }
        return \method_exists($parentClassName, $methodName);
    }
    private function createParentClassMethodCall(string $methodName) : \PhpParser\Node\Stmt\Expression
    {
        $staticCall = new \PhpParser\Node\Expr\StaticCall(new \PhpParser\Node\Name('parent'), $methodName);
        return new \PhpParser\Node\Stmt\Expression($staticCall);
    }
    /**
     * @return ReflectionProperty[]
     */
    private function getParentClassPublicAndProtectedPropertyReflections(string $className) : array
    {
        /** @var string[] $parentClassNames */
        $parentClassNames = (array) \class_parents($className);
        $propertyReflections = [];
        foreach ($parentClassNames as $parentClassName) {
            $parentClassReflection = new \ReflectionClass($parentClassName);
            $currentPropertyReflections = $parentClassReflection->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED);
            $propertyReflections = \array_merge($propertyReflections, $currentPropertyReflections);
        }
        return $propertyReflections;
    }
}
