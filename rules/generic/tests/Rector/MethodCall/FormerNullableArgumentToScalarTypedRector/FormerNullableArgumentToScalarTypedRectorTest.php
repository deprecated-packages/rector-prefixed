<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\MethodCall\FormerNullableArgumentToScalarTypedRector;

use Iterator;
use Rector\Generic\Rector\MethodCall\FormerNullableArgumentToScalarTypedRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210104\Symplify\SmartFileSystem\SmartFileInfo;
final class FormerNullableArgumentToScalarTypedRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210104\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Generic\Rector\MethodCall\FormerNullableArgumentToScalarTypedRector::class;
    }
}
