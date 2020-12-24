<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\RemoveParentRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\RemoveParentRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\RemoveParentRector\Source\ParentTypeToBeRemoved;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveParentRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\RemoveParentRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_\RemoveParentRector::PARENT_TYPES_TO_REMOVE => [\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\Class_\RemoveParentRector\Source\ParentTypeToBeRemoved::class]]];
    }
}
