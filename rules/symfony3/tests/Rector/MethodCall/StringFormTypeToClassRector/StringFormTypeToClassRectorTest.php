<?php

declare (strict_types=1);
namespace Rector\Symfony3\Tests\Rector\MethodCall\StringFormTypeToClassRector;

use Iterator;
use Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210212\Symplify\SmartFileSystem\SmartFileInfo;
final class StringFormTypeToClassRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210212\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Symfony3\Rector\MethodCall\StringFormTypeToClassRector::class;
    }
}
