<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection\SourceLocator;

use PHPStan\Testing\TestCase;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\ClassReflector;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\FunctionReflector;
use _PhpScoperabd03f0baf05\TestDirectorySourceLocator\AFoo;
class OptimizedDirectorySourceLocatorTest extends \PHPStan\Testing\TestCase
{
    public function dataClass() : array
    {
        return [[\_PhpScoperabd03f0baf05\TestDirectorySourceLocator\AFoo::class, \_PhpScoperabd03f0baf05\TestDirectorySourceLocator\AFoo::class, 'a.php'], ['_PhpScoperabd03f0baf05\\testdirectorySourceLocator\\aFoo', \_PhpScoperabd03f0baf05\TestDirectorySourceLocator\AFoo::class, 'a.php'], [\_PhpScoperabd03f0baf05\BFoo::class, \_PhpScoperabd03f0baf05\BFoo::class, 'b.php'], ['bfOO', \_PhpScoperabd03f0baf05\BFoo::class, 'b.php']];
    }
    /**
     * @dataProvider dataClass
     * @param string $className
     * @param string $file
     */
    public function testClass(string $className, string $expectedClassName, string $file) : void
    {
        $factory = self::getContainer()->getByType(\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorFactory::class);
        $locator = $factory->create(__DIR__ . '/data/directory');
        $classReflector = new \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\ClassReflector($locator);
        $classReflection = $classReflector->reflect($className);
        $this->assertSame($expectedClassName, $classReflection->getName());
        $this->assertNotNull($classReflection->getFileName());
        $this->assertSame($file, \basename($classReflection->getFileName()));
    }
    public function dataFunctionExists() : array
    {
        return [['_PhpScoperabd03f0baf05\\TestDirectorySourceLocator\\doLorem', '_PhpScoperabd03f0baf05\\TestDirectorySourceLocator\\doLorem', 'a.php'], ['_PhpScoperabd03f0baf05\\testdirectorysourcelocator\\doLorem', '_PhpScoperabd03f0baf05\\TestDirectorySourceLocator\\doLorem', 'a.php'], ['doBar', 'doBar', 'b.php'], ['doBaz', 'doBaz', 'b.php'], ['dobaz', 'doBaz', 'b.php']];
    }
    /**
     * @dataProvider dataFunctionExists
     * @param string $functionName
     * @param string $expectedFunctionName
     * @param string $file
     */
    public function testFunctionExists(string $functionName, string $expectedFunctionName, string $file) : void
    {
        $factory = self::getContainer()->getByType(\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorFactory::class);
        $locator = $factory->create(__DIR__ . '/data/directory');
        $classReflector = new \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\ClassReflector($locator);
        $functionReflector = new \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\FunctionReflector($locator, $classReflector);
        $functionReflection = $functionReflector->reflect($functionName);
        $this->assertSame($expectedFunctionName, $functionReflection->getName());
        $this->assertNotNull($functionReflection->getFileName());
        $this->assertSame($file, \basename($functionReflection->getFileName()));
    }
    public function dataFunctionDoesNotExist() : array
    {
        return [['doFoo'], ['_PhpScoperabd03f0baf05\\TestDirectorySourceLocator\\doFoo']];
    }
    /**
     * @dataProvider dataFunctionDoesNotExist
     * @param string $functionName
     */
    public function testFunctionDoesNotExist(string $functionName) : void
    {
        $factory = self::getContainer()->getByType(\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorFactory::class);
        $locator = $factory->create(__DIR__ . '/data/directory');
        $classReflector = new \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\ClassReflector($locator);
        $functionReflector = new \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\FunctionReflector($locator, $classReflector);
        $this->expectException(\_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound::class);
        $functionReflector->reflect($functionName);
    }
}
