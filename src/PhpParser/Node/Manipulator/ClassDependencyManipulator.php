<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ChildAndParentClassManipulator $childAndParentClassManipulator, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassMethodAssignManipulator $classMethodAssignManipulator, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\StmtsManipulator $stmtsManipulator)
    {
        $this->classMethodAssignManipulator = $classMethodAssignManipulator;
        $this->nodeFactory = $nodeFactory;
        $this->childAndParentClassManipulator = $childAndParentClassManipulator;
        $this->stmtsManipulator = $stmtsManipulator;
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function addConstructorDependency(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, string $name, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : void
    {
        if ($this->isPropertyAlreadyAvailableInTheClassOrItsParents($class, $name)) {
            return;
        }
        $this->classInsertManipulator->addPropertyToClass($class, $name, $type);
        $assign = $this->nodeFactory->createPropertyAssignment($name);
        $this->addConstructorDependencyWithCustomAssign($class, $name, $type, $assign);
    }
    public function addConstructorDependencyWithCustomAssign(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, string $name, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign $assign) : void
    {
        $constructorMethod = $class->getMethod(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        /** @var ClassMethod|null $constructorMethod */
        if ($constructorMethod !== null) {
            $this->classMethodAssignManipulator->addParameterAndAssignToMethod($constructorMethod, $name, $type, $assign);
            return;
        }
        $constructorMethod = $this->nodeFactory->createPublicMethod(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $this->classMethodAssignManipulator->addParameterAndAssignToMethod($constructorMethod, $name, $type, $assign);
        $this->childAndParentClassManipulator->completeParentConstructor($class, $constructorMethod);
        $this->classInsertManipulator->addAsFirstMethod($class, $constructorMethod);
        $this->childAndParentClassManipulator->completeChildConstructors($class, $constructorMethod);
    }
    /**
     * @param Stmt[] $stmts
     */
    public function addStmtsToConstructorIfNotThereYet(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, array $stmts) : void
    {
        $classMethod = $class->getMethod(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($classMethod === null) {
            $classMethod = $this->nodeFactory->createPublicMethod(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT);
            // keep parent constructor call
            if ($this->hasClassParentClassMethod($class, \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
                $classMethod->stmts[] = $this->createParentClassMethodCall(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT);
            }
            $classMethod->stmts = \array_merge((array) $classMethod->stmts, $stmts);
            $class->stmts = \array_merge((array) $class->stmts, [$classMethod]);
            return;
        }
        $stmts = $this->stmtsManipulator->filterOutExistingStmts($classMethod, $stmts);
        // all stmts are already there → skip
        if ($stmts === []) {
            return;
        }
        $classMethod->stmts = \array_merge($stmts, (array) $classMethod->stmts);
    }
    public function addInjectProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, string $propertyName, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $propertyType) : void
    {
        if ($this->isPropertyAlreadyAvailableInTheClassOrItsParents($class, $propertyName)) {
            return;
        }
        $this->classInsertManipulator->addInjectPropertyToClass($class, $propertyName, $propertyType);
    }
    private function isPropertyAlreadyAvailableInTheClassOrItsParents(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, string $propertyName) : bool
    {
        $className = $class->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return \false;
        }
        if (!\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($className)) {
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
    private function hasClassParentClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, string $methodName) : bool
    {
        $parentClassName = $class->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName === null) {
            return \false;
        }
        return \method_exists($parentClassName, $methodName);
    }
    private function createParentClassMethodCall(string $methodName) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression
    {
        $staticCall = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('parent'), $methodName);
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression($staticCall);
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
