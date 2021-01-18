<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\FuncCall\FuncCallToNewRector;

use Iterator;
use Rector\Generic\Rector\FuncCall\FuncCallToNewRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210118\Symplify\SmartFileSystem\SmartFileInfo;
final class FuncCallToNewRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210118\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\Generic\Rector\FuncCall\FuncCallToNewRector::class => [\Rector\Generic\Rector\FuncCall\FuncCallToNewRector::FUNCTION_TO_NEW => ['collection' => ['Collection']]]];
    }
}
