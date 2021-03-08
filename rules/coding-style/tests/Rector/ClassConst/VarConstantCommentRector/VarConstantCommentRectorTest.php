<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\ClassConst\VarConstantCommentRector;

use Iterator;
use Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210308\Symplify\SmartFileSystem\SmartFileInfo;
final class VarConstantCommentRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210308\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector::class;
    }
}
