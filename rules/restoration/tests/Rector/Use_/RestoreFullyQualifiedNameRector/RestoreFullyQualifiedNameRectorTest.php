<?php

declare (strict_types=1);
namespace Rector\Restoration\Tests\Rector\Use_\RestoreFullyQualifiedNameRector;

use Iterator;
use Rector\Restoration\Rector\Use_\RestoreFullyQualifiedNameRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210207\Symplify\SmartFileSystem\SmartFileInfo;
final class RestoreFullyQualifiedNameRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210207\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Restoration\Rector\Use_\RestoreFullyQualifiedNameRector::class;
    }
}
