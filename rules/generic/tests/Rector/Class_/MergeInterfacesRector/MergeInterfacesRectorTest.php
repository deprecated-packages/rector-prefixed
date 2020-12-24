<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\MergeInterfacesRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeInterface;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeOldInterface;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class MergeInterfacesRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\MergeInterfacesRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\MergeInterfacesRector::OLD_TO_NEW_INTERFACES => [\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeOldInterface::class => \_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeInterface::class]]];
    }
}
