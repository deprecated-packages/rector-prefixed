<?php

declare (strict_types=1);
namespace Rector\Php70\Tests\Rector\If_\IfToSpaceshipRector;

use Iterator;
use Rector\Php70\Rector\If_\IfToSpaceshipRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210217\Symplify\SmartFileSystem\SmartFileInfo;
final class IfToSpaceshipRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210217\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php70\Rector\If_\IfToSpaceshipRector::class;
    }
}
