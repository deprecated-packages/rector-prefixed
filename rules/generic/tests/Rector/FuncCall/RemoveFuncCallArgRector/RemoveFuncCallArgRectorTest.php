<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\FuncCall\RemoveFuncCallArgRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\RemoveFuncCallArg;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use SplFileInfo;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveFuncCallArgRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    /**
     * @return Iterator<SplFileInfo>
     */
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::REMOVED_FUNCTION_ARGUMENTS => [new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\RemoveFuncCallArg('ldap_first_attribute', 2)]]];
    }
}
