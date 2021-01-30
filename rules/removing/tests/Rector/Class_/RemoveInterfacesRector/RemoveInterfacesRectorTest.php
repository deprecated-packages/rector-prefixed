<?php

declare (strict_types=1);
namespace Rector\Removing\Tests\Rector\Class_\RemoveInterfacesRector;

use Iterator;
use Rector\Removing\Rector\Class_\RemoveInterfacesRector;
use Rector\Removing\Tests\Rector\Class_\RemoveInterfacesRector\Source\SomeInterface;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210130\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveInterfacesRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210130\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Removing\Rector\Class_\RemoveInterfacesRector::class => [\Rector\Removing\Rector\Class_\RemoveInterfacesRector::INTERFACES_TO_REMOVE => [\Rector\Removing\Tests\Rector\Class_\RemoveInterfacesRector\Source\SomeInterface::class]]];
    }
}
