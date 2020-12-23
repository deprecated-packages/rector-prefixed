<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\Tests\Rector\FuncCall\RemoveFuncCallArgRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector;
use _PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\RemoveFuncCallArg;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use SplFileInfo;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveFuncCallArgRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::class => [\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::REMOVED_FUNCTION_ARGUMENTS => [new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\RemoveFuncCallArg('ldap_first_attribute', 2)]]];
    }
}
