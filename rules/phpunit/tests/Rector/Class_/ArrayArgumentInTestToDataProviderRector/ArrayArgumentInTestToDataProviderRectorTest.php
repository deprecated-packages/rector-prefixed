<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\Tests\Rector\Class_\ArrayArgumentInTestToDataProviderRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\Class_\ArrayArgumentInTestToDataProviderRector;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\ValueObject\ArrayArgumentToDataProvider;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ArrayArgumentInTestToDataProviderRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\Class_\ArrayArgumentInTestToDataProviderRector::class => [\_PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\Class_\ArrayArgumentInTestToDataProviderRector::ARRAY_ARGUMENTS_TO_DATA_PROVIDERS => [new \_PhpScoperb75b35f52b74\Rector\PHPUnit\ValueObject\ArrayArgumentToDataProvider('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'doTestMultiple', 'doTestSingle', 'variable')]]];
    }
}
