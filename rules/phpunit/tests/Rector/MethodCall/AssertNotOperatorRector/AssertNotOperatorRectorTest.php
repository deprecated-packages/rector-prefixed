<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\MethodCall\AssertNotOperatorRector;

use Iterator;
use Rector\PHPUnit\Rector\MethodCall\AssertNotOperatorRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class AssertNotOperatorRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\PHPUnit\Rector\MethodCall\AssertNotOperatorRector::class;
    }
}
