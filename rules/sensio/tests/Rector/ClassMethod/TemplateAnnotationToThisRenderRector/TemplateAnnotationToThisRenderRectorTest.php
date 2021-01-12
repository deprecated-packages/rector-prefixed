<?php

declare (strict_types=1);
namespace Rector\Sensio\Tests\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;

use Iterator;
use Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210112\Symplify\SmartFileSystem\SmartFileInfo;
final class TemplateAnnotationToThisRenderRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210112\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector::class;
    }
}
