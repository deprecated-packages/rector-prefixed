<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector;
use _PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass;
use _PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\FactoryClass;
use _PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ArrayToFluentCall;
use _PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\FactoryMethod;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ArrayToFluentCallRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::class => [\_PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::ARRAYS_TO_FLUENT_CALLS => [new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ArrayToFluentCall(\_PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass::class, ['name' => 'setName', 'size' => 'setSize'])], \_PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ArrayToFluentCallRector::FACTORY_METHODS => [new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\FactoryMethod(\_PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\FactoryClass::class, 'buildClass', \_PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\Source\ConfigurableClass::class, 2)]]];
    }
}
