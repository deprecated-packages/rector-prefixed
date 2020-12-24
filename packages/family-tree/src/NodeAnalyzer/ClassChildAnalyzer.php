<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\FamilyTree\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionClass;
final class ClassChildAnalyzer
{
    public function hasChildClassConstructor(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        $childClasses = $this->getChildClasses($class);
        foreach ($childClasses as $childClass) {
            if (!\class_exists($childClass)) {
                continue;
            }
            $reflectionClass = new \ReflectionClass($childClass);
            $constructorReflectionMethod = $reflectionClass->getConstructor();
            if ($constructorReflectionMethod === null) {
                continue;
            }
            if ($constructorReflectionMethod->class !== $childClass) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    public function hasParentClassConstructor(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        $className = $class->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return \false;
        }
        /** @var string[] $classParents */
        $classParents = (array) \class_parents($className);
        foreach ($classParents as $classParent) {
            $parentReflectionClass = new \ReflectionClass($classParent);
            $constructMethodReflection = $parentReflectionClass->getConstructor();
            if ($constructMethodReflection === null) {
                continue;
            }
            if ($constructMethodReflection->class !== $classParent) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    /**
     * @return class-string[]
     */
    private function getChildClasses(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $className = $class->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return [];
        }
        $childClasses = [];
        foreach (\get_declared_classes() as $declaredClass) {
            if (!\is_a($declaredClass, $className, \true)) {
                continue;
            }
            if ($declaredClass === $className) {
                continue;
            }
            $childClasses[] = $declaredClass;
        }
        return $childClasses;
    }
}
