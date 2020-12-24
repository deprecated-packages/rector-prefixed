<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php80\Tests\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class FinalPrivateToPrivateVisibilityRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     * @requires PHP < 8.0
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
        return \_PhpScoper0a6b37af0871\Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector::class;
    }
}
