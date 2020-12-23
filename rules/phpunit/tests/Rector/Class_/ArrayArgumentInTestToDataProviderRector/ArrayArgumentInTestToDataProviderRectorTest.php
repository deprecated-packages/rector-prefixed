<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPUnit\Tests\Rector\Class_\ArrayArgumentInTestToDataProviderRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\Class_\ArrayArgumentInTestToDataProviderRector;
use _PhpScoper0a2ac50786fa\Rector\PHPUnit\ValueObject\ArrayArgumentToDataProvider;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class ArrayArgumentInTestToDataProviderRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\Class_\ArrayArgumentInTestToDataProviderRector::class => [\_PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\Class_\ArrayArgumentInTestToDataProviderRector::ARRAY_ARGUMENTS_TO_DATA_PROVIDERS => [new \_PhpScoper0a2ac50786fa\Rector\PHPUnit\ValueObject\ArrayArgumentToDataProvider('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'doTestMultiple', 'doTestSingle', 'variable')]]];
    }
}
