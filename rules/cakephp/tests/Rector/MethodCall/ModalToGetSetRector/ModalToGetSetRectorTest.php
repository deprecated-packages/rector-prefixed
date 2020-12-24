<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector;
use _PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType;
use _PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ModalToGetSetRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::class => [\_PhpScopere8e811afab72\Rector\CakePHP\Rector\MethodCall\ModalToGetSetRector::UNPREFIXED_METHODS_TO_GET_SET => [new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'config', null, null, 2, 'array'), new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'customMethod', 'customMethodGetName', 'customMethodSetName', 2, 'array'), new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'makeEntity', 'createEntity', 'generateEntity'), new \_PhpScopere8e811afab72\Rector\CakePHP\ValueObject\ModalToGetSet(\_PhpScopere8e811afab72\Rector\CakePHP\Tests\Rector\MethodCall\ModalToGetSetRector\Source\SomeModelType::class, 'method')]]];
    }
}
