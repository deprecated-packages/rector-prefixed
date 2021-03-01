<?php

declare (strict_types=1);
namespace Rector\Symfony2\Tests\Rector\MethodCall\AddFlashRector;

use Iterator;
use Rector\Symfony2\Rector\MethodCall\AddFlashRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210301\Symplify\SmartFileSystem\SmartFileInfo;
final class AddFlashRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210301\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Symfony2\Rector\MethodCall\AddFlashRector::class;
    }
}
