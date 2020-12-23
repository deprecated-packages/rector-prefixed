<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Symfony5\Tests\Rector\New_\PropertyPathMapperToDataMapperRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Symfony5\Rector\New_\PropertyPathMapperToDataMapperRector;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyPathMapperToDataMapperRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a2ac50786fa\Rector\Symfony5\Rector\New_\PropertyPathMapperToDataMapperRector::class;
    }
}
