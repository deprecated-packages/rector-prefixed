<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\WrapReturnRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\WrapReturnRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\WrapReturnRector\Source\SomeReturnClass;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\WrapReturn;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class WrapReturnRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\WrapReturnRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\WrapReturnRector::TYPE_METHOD_WRAPS => [new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\WrapReturn(\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\WrapReturnRector\Source\SomeReturnClass::class, 'getItem', \true)]]];
    }
}
