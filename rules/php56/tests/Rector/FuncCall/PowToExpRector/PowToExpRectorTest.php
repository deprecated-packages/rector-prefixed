<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php56\Tests\Rector\FuncCall\PowToExpRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Php56\Rector\FuncCall\PowToExpRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * Some tests copied from:
 * - https://github.com/FriendsOfPHP/PHP-CS-Fixer/commit/14660432d9d0b66bf65135d793b52872cc6eccbc#diff-b412676c923661ef450f4a0903c5442a
 */
final class PowToExpRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\Php56\Rector\FuncCall\PowToExpRector::class;
    }
}
