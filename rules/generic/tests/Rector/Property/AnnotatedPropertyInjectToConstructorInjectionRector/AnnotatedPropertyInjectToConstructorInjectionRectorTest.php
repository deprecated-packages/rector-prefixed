<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\Property\AnnotatedPropertyInjectToConstructorInjectionRector;

use Iterator;
use Rector\Generic\Rector\Property\AnnotatedPropertyInjectToConstructorInjectionRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210103\Symplify\SmartFileSystem\SmartFileInfo;
final class AnnotatedPropertyInjectToConstructorInjectionRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210103\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Generic\Rector\Property\AnnotatedPropertyInjectToConstructorInjectionRector::class;
    }
}
