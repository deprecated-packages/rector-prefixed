<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector;
use _PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType;
use _PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ModalToGetSetRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::class => [\_PhpScoperb75b35f52b74\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::UNPREFIXED_METHODS_TO_GET_SET => [new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'config', null, null, 2, 'array'), new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'customMethod', 'customMethodGetName', 'customMethodSetName', 2, 'array'), new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'makeEntity', 'createEntity', 'generateEntity'), new \_PhpScoperb75b35f52b74\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScoperb75b35f52b74\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'method')]]];
    }
}
