<?php

declare (strict_types=1);
namespace Rector\Php54\Tests\Rector\FuncCall\RemoveReferenceFromCallRector;

use Iterator;
use Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210102\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveReferenceFromCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210102\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfoWithoutAutoload($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector::class;
    }
}
