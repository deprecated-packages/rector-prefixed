<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\AddMethodParentCallRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\AddMethodParentCallRector\Source\ParentClassWithNewConstructor;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class AddMethodParentCallRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\AddMethodParentCallRector::METHODS_BY_PARENT_TYPES => [\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\AddMethodParentCallRector\Source\ParentClassWithNewConstructor::class => '__construct']]];
    }
}
