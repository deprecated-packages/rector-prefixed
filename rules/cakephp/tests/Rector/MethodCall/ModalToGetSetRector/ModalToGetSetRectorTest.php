<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector;
use _PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType;
use _PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ModalToGetSetRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::class => [\_PhpScoper0a6b37af0871\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::UNPREFIXED_METHODS_TO_GET_SET => [new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'config', null, null, 2, 'array'), new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'customMethod', 'customMethodGetName', 'customMethodSetName', 2, 'array'), new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'makeEntity', 'createEntity', 'generateEntity'), new \_PhpScoper0a6b37af0871\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScoper0a6b37af0871\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'method')]]];
    }
}
