<?php

declare (strict_types=1);
namespace Rector\PHPUnit\TestClassResolver;

use RectorPrefix20210420\Nette\Utils\Strings;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Reflection\ReflectionProvider;
use Rector\NodeNameResolver\NodeNameResolver;
/**
 * @see \Rector\PHPUnit\Tests\TestClassResolver\TestClassResolverTest
 */
final class TestClassResolver
{
    /**
     * @var string
     */
    const TEST = 'Test';
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var PHPUnitTestCaseClassesProvider
     */
    private $phpUnitTestCaseClassesProvider;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\PHPUnit\TestClassResolver\PHPUnitTestCaseClassesProvider $phpUnitTestCaseClassesProvider, \PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->phpUnitTestCaseClassesProvider = $phpUnitTestCaseClassesProvider;
        $this->reflectionProvider = $reflectionProvider;
    }
    /**
     * @return string|null
     */
    public function resolveFromClassName(string $className)
    {
        // fallback for unit tests that only have extra "Test" suffix
        if ($this->reflectionProvider->hasClass($className . self::TEST)) {
            return $className . self::TEST;
        }
        $shortClassName = $this->resolveShortClassName($className);
        $testShortClassName = $shortClassName . self::TEST;
        $phpUnitTestCaseClasses = $this->phpUnitTestCaseClassesProvider->provide();
        $classNamespaceParts = $this->resolveNamespaceParts($className);
        $classNamespaceParts[] = 'Tests';
        \sort($classNamespaceParts);
        foreach ($phpUnitTestCaseClasses as $phpUnitTestCaseClass) {
            // 1. is short class match
            if (!\RectorPrefix20210420\Nette\Utils\Strings::endsWith($phpUnitTestCaseClass, '\\' . $testShortClassName)) {
                continue;
            }
            $phpUnitTestNamespaceParts = $this->resolveNamespaceParts($phpUnitTestCaseClass);
            \sort($phpUnitTestNamespaceParts);
            $nestedPhpUnitTestNamespaceParts = \array_merge($classNamespaceParts, [$shortClassName]);
            \sort($nestedPhpUnitTestNamespaceParts);
            if ($classNamespaceParts === $phpUnitTestNamespaceParts) {
                return $phpUnitTestCaseClass;
            }
            if ($nestedPhpUnitTestNamespaceParts === $phpUnitTestNamespaceParts) {
                return $phpUnitTestCaseClass;
            }
            return null;
        }
        return null;
    }
    /**
     * @return string|null
     */
    public function resolveFromClass(\PhpParser\Node\Stmt\Class_ $class)
    {
        $className = $this->nodeNameResolver->getName($class);
        if ($className === null) {
            return null;
        }
        return $this->resolveFromClassName($className);
    }
    /**
     * @return string|null
     */
    private function resolveShortClassName(string $className)
    {
        return \RectorPrefix20210420\Nette\Utils\Strings::after($className, '\\', -1);
    }
    /**
     * @return string[]
     */
    private function resolveNamespaceParts(string $className) : array
    {
        $namespacePart = (string) \RectorPrefix20210420\Nette\Utils\Strings::before($className, '\\', -1);
        return \explode('\\', $namespacePart);
    }
}
