<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Expression\MethodCallToReturnRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector\Source\ReturnDeny;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\MethodCallToReturn;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallToReturnRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Expression\MethodCallToReturnRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Expression\MethodCallToReturnRector::METHOD_CALL_WRAPS => [new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\MethodCallToReturn(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector\Source\ReturnDeny::class, 'deny')]]];
    }
}
