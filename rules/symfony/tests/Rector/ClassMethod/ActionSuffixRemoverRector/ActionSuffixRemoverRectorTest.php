<?php

declare (strict_types=1);
namespace Rector\Symfony\Tests\Rector\ClassMethod\ActionSuffixRemoverRector;

use Iterator;
use Rector\Symfony\Rector\ClassMethod\ActionSuffixRemoverRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210201\Symplify\SmartFileSystem\SmartFileInfo;
final class ActionSuffixRemoverRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210201\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Symfony\Rector\ClassMethod\ActionSuffixRemoverRector::class;
    }
}
