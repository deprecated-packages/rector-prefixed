<?php

declare (strict_types=1);
namespace Rector\DeadDocBlock\Tests\Rector\Node\RemoveNonExistingVarAnnotationRector;

use Iterator;
use Rector\DeadDocBlock\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210106\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveNonExistingVarAnnotationRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210106\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadDocBlock\Rector\Node\RemoveNonExistingVarAnnotationRector::class;
    }
}
