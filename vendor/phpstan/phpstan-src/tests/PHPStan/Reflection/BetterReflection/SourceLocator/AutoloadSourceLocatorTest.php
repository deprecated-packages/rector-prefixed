<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection\SourceLocator;

use PHPStan\Testing\TestCase;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionClass;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\ClassReflector;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\ConstantReflector;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\FunctionReflector;
use _PhpScoper88fe6e0ad041\TestSingleFileSourceLocator\AFoo;
use _PhpScoper88fe6e0ad041\TestSingleFileSourceLocator\InCondition;
function testFunctionForLocator() : void
{
}
class AutoloadSourceLocatorTest extends \PHPStan\Testing\TestCase
{
    public function testAutoloadEverythingInFile() : void
    {
        /** @var FunctionReflector $functionReflector */
        $functionReflector = null;
        $locator = new \PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator(self::getContainer()->getByType(\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher::class));
        $classReflector = new \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\ClassReflector($locator);
        $functionReflector = new \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\FunctionReflector($locator, $classReflector);
        $constantReflector = new \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\ConstantReflector($locator, $classReflector);
        $aFoo = $classReflector->reflect(\_PhpScoper88fe6e0ad041\TestSingleFileSourceLocator\AFoo::class);
        $this->assertNotNull($aFoo->getFileName());
        $this->assertSame('a.php', \basename($aFoo->getFileName()));
        $testFunctionReflection = $functionReflector->reflect('PHPStan\\Reflection\\BetterReflection\\SourceLocator\\testFunctionForLocator');
        $this->assertSame(\str_replace('\\', '/', __FILE__), $testFunctionReflection->getFileName());
        $someConstant = $constantReflector->reflect('_PhpScoper88fe6e0ad041\\TestSingleFileSourceLocator\\SOME_CONSTANT');
        $this->assertNotNull($someConstant->getFileName());
        $this->assertSame('a.php', \basename($someConstant->getFileName()));
        $this->assertSame(1, $someConstant->getValue());
        $anotherConstant = $constantReflector->reflect('_PhpScoper88fe6e0ad041\\TestSingleFileSourceLocator\\ANOTHER_CONSTANT');
        $this->assertNotNull($anotherConstant->getFileName());
        $this->assertSame('a.php', \basename($anotherConstant->getFileName()));
        $this->assertSame(2, $anotherConstant->getValue());
        $doFooFunctionReflection = $functionReflector->reflect('_PhpScoper88fe6e0ad041\\TestSingleFileSourceLocator\\doFoo');
        $this->assertSame('_PhpScoper88fe6e0ad041\\TestSingleFileSourceLocator\\doFoo', $doFooFunctionReflection->getName());
        $this->assertNotNull($doFooFunctionReflection->getFileName());
        $this->assertSame('a.php', \basename($doFooFunctionReflection->getFileName()));
        \class_exists(\_PhpScoper88fe6e0ad041\TestSingleFileSourceLocator\InCondition::class);
        $classInCondition = $classReflector->reflect(\_PhpScoper88fe6e0ad041\TestSingleFileSourceLocator\InCondition::class);
        $classInConditionFilename = $classInCondition->getFileName();
        $this->assertNotNull($classInConditionFilename);
        $this->assertSame('a.php', \basename($classInConditionFilename));
        $this->assertSame(\_PhpScoper88fe6e0ad041\TestSingleFileSourceLocator\InCondition::class, $classInCondition->getName());
        $this->assertSame(25, $classInCondition->getStartLine());
        $this->assertInstanceOf(\_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionClass::class, $classInCondition->getParentClass());
        $this->assertSame(\_PhpScoper88fe6e0ad041\TestSingleFileSourceLocator\AFoo::class, $classInCondition->getParentClass()->getName());
    }
}
