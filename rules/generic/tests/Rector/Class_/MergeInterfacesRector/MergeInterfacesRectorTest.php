<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector;

use Iterator;
use Rector\Generic\Rector\Class_\MergeInterfacesRector;
use Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeInterface;
use Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeOldInterface;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo;
final class MergeInterfacesRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Generic\Rector\Class_\MergeInterfacesRector::class => [\Rector\Generic\Rector\Class_\MergeInterfacesRector::OLD_TO_NEW_INTERFACES => [\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeOldInterface::class => \Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeInterface::class]]];
    }
}
