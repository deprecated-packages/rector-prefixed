<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Tests\Rector\Class_\ArrayArgumentInTestToDataProviderRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\Class_\ArrayArgumentInTestToDataProviderRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\ValueObject\ArrayArgumentToDataProvider;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ArrayArgumentInTestToDataProviderRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\Class_\ArrayArgumentInTestToDataProviderRector::class => [\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\Class_\ArrayArgumentInTestToDataProviderRector::ARRAY_ARGUMENTS_TO_DATA_PROVIDERS => [new \_PhpScopere8e811afab72\Rector\PHPUnit\ValueObject\ArrayArgumentToDataProvider('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'doTestMultiple', 'doTestSingle', 'variable')]]];
    }
}
