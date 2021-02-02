<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\Assign\DimFetchAssignToMethodCallRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\Assign\DimFetchAssignToMethodCallRector;
use Rector\Transform\ValueObject\DimFetchAssignToMethodCall;
use RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo;
final class DimFetchAssignToMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\Assign\DimFetchAssignToMethodCallRector::class => [\Rector\Transform\Rector\Assign\DimFetchAssignToMethodCallRector::DIM_FETCH_ASSIGN_TO_METHOD_CALL => [new \Rector\Transform\ValueObject\DimFetchAssignToMethodCall('Nette\\Application\\Routers\\RouteList', 'Nette\\Application\\Routers\\Route', 'addRoute')]]];
    }
}
