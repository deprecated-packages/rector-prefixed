<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Tests\Rector\ClassConstFetch\ConsoleExceptionToErrorEventConstantRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\ClassConstFetch\ConsoleExceptionToErrorEventConstantRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class ConsoleExceptionToErrorEventConstantRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\Rector\Symfony3\Rector\ClassConstFetch\ConsoleExceptionToErrorEventConstantRector::class;
    }
}
