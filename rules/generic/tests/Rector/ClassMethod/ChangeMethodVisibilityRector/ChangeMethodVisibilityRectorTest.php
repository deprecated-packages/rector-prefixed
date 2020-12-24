<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeMethodVisibilityRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => [new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility(\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBePublicMethod', 'public'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility(\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBeProtectedMethod', 'protected'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility(\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBePrivateMethod', 'private'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility(\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBePublicStaticMethod', 'public')]]];
    }
}
