<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\FactoryClass;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ArrayToFluentCall;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\FactoryMethod;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class ArrayToFluentCallRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::ARRAYS_TO_FLUENT_CALLS => [new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ArrayToFluentCall(\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass::class, ['name' => 'setName', 'size' => 'setSize'])], \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::FACTORY_METHODS => [new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\FactoryMethod(\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\FactoryClass::class, 'buildClass', \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass::class, 2)]]];
    }
}
