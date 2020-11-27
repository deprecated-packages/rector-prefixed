<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection\SourceLocator;

use PHPStan\Testing\TestCase;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\ClassReflector;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\ConstantReflector;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\FunctionReflector;
use _PhpScoper006a73f0e455\TestSingleFileSourceLocator\AFoo;
class OptimizedSingleFileSourceLocatorTest extends \PHPStan\Testing\TestCase
{
    public function dataClass() : array
    {
        return [[\_PhpScoper006a73f0e455\TestSingleFileSourceLocator\AFoo::class, \_PhpScoper006a73f0e455\TestSingleFileSourceLocator\AFoo::class, __DIR__ . '/data/a.php'], ['_PhpScoper006a73f0e455\\testSinglefileSourceLocator\\afoo', \_PhpScoper006a73f0e455\TestSingleFileSourceLocator\AFoo::class, __DIR__ . '/data/a.php'], [\_PhpScoper006a73f0e455\SingleFileSourceLocatorTestClass::class, \_PhpScoper006a73f0e455\SingleFileSourceLocatorTestClass::class, __DIR__ . '/data/b.php'], ['SinglefilesourceLocatortestClass', \_PhpScoper006a73f0e455\SingleFileSourceLocatorTestClass::class, __DIR__ . '/data/b.php']];
    }
    /**
     * @dataProvider dataClass
     * @param string $className
     * @param string $expectedClassName
     * @param string $file
     */
    public function testClass(string $className, string $expectedClassName, string $file) : void
    {
        $factory = self::getContainer()->getByType(\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorFactory::class);
        $locator = $factory->create($file);
        $classReflector = new \_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\ClassReflector($locator);
        $classReflection = $classReflector->reflect($className);
        $this->assertSame($expectedClassName, $classReflection->getName());
    }
    public function dataFunction() : array
    {
        return [['_PhpScoper006a73f0e455\\TestSingleFileSourceLocator\\doFoo', '_PhpScoper006a73f0e455\\TestSingleFileSourceLocator\\doFoo', __DIR__ . '/data/a.php'], ['_PhpScoper006a73f0e455\\testSingleFilesourcelocatOR\\dofoo', '_PhpScoper006a73f0e455\\TestSingleFileSourceLocator\\doFoo', __DIR__ . '/data/a.php'], ['singleFileSourceLocatorTestFunction', 'singleFileSourceLocatorTestFunction', __DIR__ . '/data/b.php'], ['singlefileSourceLocatORTestfunCTion', 'singleFileSourceLocatorTestFunction', __DIR__ . '/data/b.php']];
    }
    /**
     * @dataProvider dataFunction
     * @param string $functionName
     * @param string $expectedFunctionName
     * @param string $file
     */
    public function testFunction(string $functionName, string $expectedFunctionName, string $file) : void
    {
        $factory = self::getContainer()->getByType(\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorFactory::class);
        $locator = $factory->create($file);
        $classReflector = new \_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\ClassReflector($locator);
        $functionReflector = new \_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\FunctionReflector($locator, $classReflector);
        $functionReflection = $functionReflector->reflect($functionName);
        $this->assertSame($expectedFunctionName, $functionReflection->getName());
    }
    public function dataConst() : array
    {
        return [['_PhpScoper006a73f0e455\\ConstFile\\TABLE_NAME', 'resized_images'], ['ANOTHER_NAME', 'foo_images'], ['_PhpScoper006a73f0e455\\ConstFile\\ANOTHER_NAME', 'bar_images'], ['const_with_dir_const', \str_replace('\\', '/', __DIR__ . '/data')]];
    }
    /**
     * @dataProvider dataConst
     * @param string $constantName
     * @param mixed $value
     */
    public function testConst(string $constantName, $value) : void
    {
        $factory = self::getContainer()->getByType(\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorFactory::class);
        $locator = $factory->create(__DIR__ . '/data/const.php');
        $classReflector = new \_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\ClassReflector($locator);
        $constantReflector = new \_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\ConstantReflector($locator, $classReflector);
        $constant = $constantReflector->reflect($constantName);
        $this->assertSame($constantName, $constant->getName());
        $this->assertSame($value, $constant->getValue());
    }
    public function dataConstUnknown() : array
    {
        return [['TEST_VARIABLE']];
    }
    /**
     * @dataProvider dataConstUnknown
     * @param string $constantName
     */
    public function testConstUnknown(string $constantName) : void
    {
        $factory = self::getContainer()->getByType(\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorFactory::class);
        $locator = $factory->create(__DIR__ . '/data/const.php');
        $classReflector = new \_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\ClassReflector($locator);
        $constantReflector = new \_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\ConstantReflector($locator, $classReflector);
        $this->expectException(\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound::class);
        $constantReflector->reflect($constantName);
    }
}
