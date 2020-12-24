<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\TestClassResolver;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
/**
 * @see \Rector\PHPUnit\Tests\TestClassResolver\TestClassResolverTest
 */
final class TestClassResolver
{
    /**
     * @var string
     */
    private const TEST = 'Test';
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var PHPUnitTestCaseClassesProvider
     */
    private $phpUnitTestCaseClassesProvider;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\PHPUnit\TestClassResolver\PHPUnitTestCaseClassesProvider $phpUnitTestCaseClassesProvider)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->phpUnitTestCaseClassesProvider = $phpUnitTestCaseClassesProvider;
    }
    public function resolveFromClassName(string $className) : ?string
    {
        // fallback for unit tests that only have extra "Test" suffix
        if (\class_exists($className . self::TEST)) {
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
            if (!\_PhpScoper0a6b37af0871\Nette\Utils\Strings::endsWith($phpUnitTestCaseClass, '\\' . $testShortClassName)) {
                continue;
            }
            // 2. is namespace match
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
    public function resolveFromClass(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : ?string
    {
        $className = $this->nodeNameResolver->getName($class);
        if ($className === null) {
            return null;
        }
        return $this->resolveFromClassName($className);
    }
    private function resolveShortClassName(string $className) : ?string
    {
        return \_PhpScoper0a6b37af0871\Nette\Utils\Strings::after($className, '\\', -1);
    }
    /**
     * @return string[]
     */
    private function resolveNamespaceParts(string $className) : array
    {
        $namespacePart = (string) \_PhpScoper0a6b37af0871\Nette\Utils\Strings::before($className, '\\', -1);
        return \explode('\\', $namespacePart);
    }
}
