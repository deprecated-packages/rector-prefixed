<?php

declare (strict_types=1);
namespace Rector\Php52\Tests\Rector\Property\VarToPublicPropertyRector;

use Iterator;
use Rector\Php52\Rector\Property\VarToPublicPropertyRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210119\Symplify\SmartFileSystem\SmartFileInfo;
final class VarToPublicPropertyRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210119\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php52\Rector\Property\VarToPublicPropertyRector::class;
    }
}
