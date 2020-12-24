<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Tests\Rector\Variable\PhpSpecToPHPUnitRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\Class_\AddMockPropertiesRector;
use _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\Class_\PhpSpecClassToPHPUnitClassRector;
use _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\ClassMethod\PhpSpecMethodToPHPUnitMethodRector;
use _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecMocksToPHPUnitMocksRector;
use _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecPromisesToPHPUnitAssertRector;
use _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\Variable\MockVariableToPropertyFetchRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class PhpSpecToPHPUnitRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [
            # 1. first convert mocks
            \_PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecMocksToPHPUnitMocksRector::class => [],
            \_PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecPromisesToPHPUnitAssertRector::class => [],
            \_PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\ClassMethod\PhpSpecMethodToPHPUnitMethodRector::class => [],
            \_PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\Class_\PhpSpecClassToPHPUnitClassRector::class => [],
            \_PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\Class_\AddMockPropertiesRector::class => [],
            \_PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\Variable\MockVariableToPropertyFetchRector::class => [],
        ];
    }
}
