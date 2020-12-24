<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Tests\Rector\Class_\RenamePropertyToMatchTypeRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class Php74TestTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePhp74');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector::class;
    }
}
