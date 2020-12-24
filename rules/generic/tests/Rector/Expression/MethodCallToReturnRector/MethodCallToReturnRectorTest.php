<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\Expression\MethodCallToReturnRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector\Source\ReturnDeny;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\MethodCallToReturn;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallToReturnRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Expression\MethodCallToReturnRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Expression\MethodCallToReturnRector::METHOD_CALL_WRAPS => [new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\MethodCallToReturn(\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector\Source\ReturnDeny::class, 'deny')]]];
    }
}
