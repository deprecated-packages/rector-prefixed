<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType;
use _PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class ModalToGetSetRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::UNPREFIXED_METHODS_TO_GET_SET => [new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'config', null, null, 2, 'array'), new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'customMethod', 'customMethodGetName', 'customMethodSetName', 2, 'array'), new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'makeEntity', 'createEntity', 'generateEntity'), new \_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScoper2a4e7ab1ecbc\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'method')]]];
    }
}
