<?php

declare (strict_types=1);
namespace Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector;

use Iterator;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210228\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveExtraParametersRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210228\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector::class;
    }
}
