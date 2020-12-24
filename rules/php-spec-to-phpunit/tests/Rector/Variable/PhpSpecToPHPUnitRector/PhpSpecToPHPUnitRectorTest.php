<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Tests\Rector\Variable\PhpSpecToPHPUnitRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\Class_\AddMockPropertiesRector;
use _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\Class_\PhpSpecClassToPHPUnitClassRector;
use _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\ClassMethod\PhpSpecMethodToPHPUnitMethodRector;
use _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecMocksToPHPUnitMocksRector;
use _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecPromisesToPHPUnitAssertRector;
use _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\Variable\MockVariableToPropertyFetchRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class PhpSpecToPHPUnitRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [
            # 1. first convert mocks
            \_PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecMocksToPHPUnitMocksRector::class => [],
            \_PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecPromisesToPHPUnitAssertRector::class => [],
            \_PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\ClassMethod\PhpSpecMethodToPHPUnitMethodRector::class => [],
            \_PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\Class_\PhpSpecClassToPHPUnitClassRector::class => [],
            \_PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\Class_\AddMockPropertiesRector::class => [],
            \_PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\Variable\MockVariableToPropertyFetchRector::class => [],
        ];
    }
}
