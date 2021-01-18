<?php

declare (strict_types=1);
namespace Rector\PhpSpecToPHPUnit\Tests\Rector\Variable\PhpSpecToPHPUnitRector;

use Iterator;
use Rector\PhpSpecToPHPUnit\Rector\Class_\AddMockPropertiesRector;
use Rector\PhpSpecToPHPUnit\Rector\Class_\PhpSpecClassToPHPUnitClassRector;
use Rector\PhpSpecToPHPUnit\Rector\ClassMethod\PhpSpecMethodToPHPUnitMethodRector;
use Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecMocksToPHPUnitMocksRector;
use Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecPromisesToPHPUnitAssertRector;
use Rector\PhpSpecToPHPUnit\Rector\Variable\MockVariableToPropertyFetchRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210118\Symplify\SmartFileSystem\SmartFileInfo;
final class PhpSpecToPHPUnitRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210118\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
            \Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecMocksToPHPUnitMocksRector::class => [],
            \Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecPromisesToPHPUnitAssertRector::class => [],
            \Rector\PhpSpecToPHPUnit\Rector\ClassMethod\PhpSpecMethodToPHPUnitMethodRector::class => [],
            \Rector\PhpSpecToPHPUnit\Rector\Class_\PhpSpecClassToPHPUnitClassRector::class => [],
            \Rector\PhpSpecToPHPUnit\Rector\Class_\AddMockPropertiesRector::class => [],
            \Rector\PhpSpecToPHPUnit\Rector\Variable\MockVariableToPropertyFetchRector::class => [],
        ];
    }
}
