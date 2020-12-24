<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector;
use _PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass;
use _PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\FactoryClass;
use _PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ArrayToFluentCall;
use _PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\FactoryMethod;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ArrayToFluentCallRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::class => [\_PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::ARRAYS_TO_FLUENT_CALLS => [new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ArrayToFluentCall(\_PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass::class, ['name' => 'setName', 'size' => 'setSize'])], \_PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::FACTORY_METHODS => [new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\FactoryMethod(\_PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\FactoryClass::class, 'buildClass', \_PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass::class, 2)]]];
    }
}
