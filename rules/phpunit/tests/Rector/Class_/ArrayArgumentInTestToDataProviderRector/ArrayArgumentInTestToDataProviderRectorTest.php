<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\Class_\ArrayArgumentInTestToDataProviderRector;

use Iterator;
use Rector\PHPUnit\Rector\Class_\ArrayArgumentInTestToDataProviderRector;
use Rector\PHPUnit\ValueObject\ArrayArgumentToDataProvider;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class ArrayArgumentInTestToDataProviderRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\PHPUnit\Rector\Class_\ArrayArgumentInTestToDataProviderRector::class => [\Rector\PHPUnit\Rector\Class_\ArrayArgumentInTestToDataProviderRector::ARRAY_ARGUMENTS_TO_DATA_PROVIDERS => [new \Rector\PHPUnit\ValueObject\ArrayArgumentToDataProvider('_PhpScoper267b3276efc2\\PHPUnit\\Framework\\TestCase', 'doTestMultiple', 'doTestSingle', 'variable')]]];
    }
}
