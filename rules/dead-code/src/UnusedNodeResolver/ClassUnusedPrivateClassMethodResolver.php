<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DeadCode\UnusedNodeResolver;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use _PhpScoper0a2ac50786fa\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use ReflectionMethod;
final class ClassUnusedPrivateClassMethodResolver
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ClassManipulator
     */
    private $classManipulator;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->classManipulator = $classManipulator;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * @return string[]
     */
    public function getClassUnusedMethodNames(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : array
    {
        /** @var string $className */
        $className = $this->nodeNameResolver->getName($class);
        $classMethodCalls = $this->nodeRepository->findMethodCallsOnClass($className);
        $usedMethodNames = \array_keys($classMethodCalls);
        $classPublicMethodNames = $this->classManipulator->getPublicMethodNames($class);
        return $this->getUnusedMethodNames($class, $classPublicMethodNames, $usedMethodNames);
    }
    /**
     * @param string[] $classPublicMethodNames
     * @param string[] $usedMethodNames
     * @return string[]
     */
    private function getUnusedMethodNames(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, array $classPublicMethodNames, array $usedMethodNames) : array
    {
        $unusedMethods = \array_diff($classPublicMethodNames, $usedMethodNames);
        $unusedMethods = $this->filterOutSystemMethods($unusedMethods);
        $unusedMethods = $this->filterOutInterfaceRequiredMethods($class, $unusedMethods);
        return $this->filterOutParentAbstractMethods($class, $unusedMethods);
    }
    /**
     * @param string[] $unusedMethods
     * @return string[]
     */
    private function filterOutSystemMethods(array $unusedMethods) : array
    {
        foreach ($unusedMethods as $key => $unusedMethod) {
            // skip Doctrine-needed methods
            if (\in_array($unusedMethod, ['getId', 'setId'], \true)) {
                unset($unusedMethods[$key]);
            }
            // skip magic methods
            if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::startsWith($unusedMethod, '__')) {
                unset($unusedMethods[$key]);
            }
        }
        return $unusedMethods;
    }
    /**
     * @param string[] $unusedMethods
     * @return string[]
     */
    private function filterOutInterfaceRequiredMethods(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, array $unusedMethods) : array
    {
        /** @var string $className */
        $className = $this->nodeNameResolver->getName($class);
        /** @var string[] $interfaces */
        $interfaces = (array) \class_implements($className);
        $interfaceMethods = [];
        foreach ($interfaces as $interface) {
            $interfaceMethods = \array_merge($interfaceMethods, \get_class_methods($interface));
        }
        return \array_diff($unusedMethods, $interfaceMethods);
    }
    /**
     * @param string[] $unusedMethods
     * @return string[]
     */
    private function filterOutParentAbstractMethods(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, array $unusedMethods) : array
    {
        if ($class->extends === null) {
            return $unusedMethods;
        }
        /** @var string[] $parentClasses */
        $parentClasses = (array) \class_parents($class);
        $parentAbstractMethods = [];
        foreach ($parentClasses as $parentClass) {
            foreach ($unusedMethods as $unusedMethod) {
                if (\in_array($unusedMethod, $parentAbstractMethods, \true)) {
                    continue;
                }
                if ($this->isMethodAbstract($parentClass, $unusedMethod)) {
                    $parentAbstractMethods[] = $unusedMethod;
                }
            }
        }
        return \array_diff($unusedMethods, $parentAbstractMethods);
    }
    private function isMethodAbstract(string $class, string $method) : bool
    {
        if (!\method_exists($class, $method)) {
            return \false;
        }
        $reflectionMethod = new \ReflectionMethod($class, $method);
        return $reflectionMethod->isAbstract();
    }
}
