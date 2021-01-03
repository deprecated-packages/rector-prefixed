<?php

declare (strict_types=1);
namespace Rector\Naming\Tests\Rector\ClassMethod\MakeGetterClassMethodNameStartWithGetRector;

use Iterator;
use Rector\Naming\Rector\ClassMethod\MakeGetterClassMethodNameStartWithGetRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210103\Symplify\SmartFileSystem\SmartFileInfo;
final class MakeGetterClassMethodNameStartWithGetRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210103\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Naming\Rector\ClassMethod\MakeGetterClassMethodNameStartWithGetRector::class;
    }
}
