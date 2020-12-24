<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php71\Tests\Rector\FuncCall\CountOnNullRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersion;
use _PhpScoper0a6b37af0871\Rector\Php71\Rector\FuncCall\CountOnNullRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class CountOnNullRectorWithPHP73Test extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureForPhp73');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\Php71\Rector\FuncCall\CountOnNullRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersion::PHP_73;
    }
}
