<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\MysqlToMysqli\Tests;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class SetTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
    protected function provideConfigFileInfo() : ?\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/../../../config/set/mysql-to-mysqli.php');
    }
}
