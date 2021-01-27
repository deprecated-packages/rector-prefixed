<?php

declare (strict_types=1);
namespace Rector\Php74\Tests\Rector\FuncCall\FilterVarToAddSlashesRector;

use Iterator;
use Rector\Php74\Rector\FuncCall\FilterVarToAddSlashesRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @requires PHP < 8.0
 */
final class FilterVarToAddSlashesRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php74\Rector\FuncCall\FilterVarToAddSlashesRector::class;
    }
}
