<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\Assign\DimFetchAssignToMethodCallRector;

use Iterator;
use Rector\Generic\Rector\Assign\DimFetchAssignToMethodCallRector;
use Rector\Generic\ValueObject\DimFetchAssignToMethodCall;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210120\Symplify\SmartFileSystem\SmartFileInfo;
final class DimFetchAssignToMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210120\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, array<string, DimFetchAssignToMethodCall[]>>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\Generic\Rector\Assign\DimFetchAssignToMethodCallRector::class => [\Rector\Generic\Rector\Assign\DimFetchAssignToMethodCallRector::DIM_FETCH_ASSIGN_TO_METHOD_CALL => [new \Rector\Generic\ValueObject\DimFetchAssignToMethodCall('Nette\\Application\\Routers\\RouteList', 'Nette\\Application\\Routers\\Route', 'addRoute')]]];
    }
}
