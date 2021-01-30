<?php

declare (strict_types=1);
namespace Rector\CodeQualityStrict\Tests\Rector\Variable\MoveVariableDeclarationNearReferenceRector;

use Iterator;
use Rector\CodeQualityStrict\Rector\Variable\MoveVariableDeclarationNearReferenceRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210130\Symplify\SmartFileSystem\SmartFileInfo;
final class MoveVariableDeclarationNearReferenceRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210130\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQualityStrict\Rector\Variable\MoveVariableDeclarationNearReferenceRector::class;
    }
}
