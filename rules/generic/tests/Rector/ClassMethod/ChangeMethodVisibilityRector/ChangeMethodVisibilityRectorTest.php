<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeMethodVisibilityRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class => [\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility(\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBePublicMethod', 'public'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility(\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBeProtectedMethod', 'protected'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility(\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBePrivateMethod', 'private'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility(\_PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBePublicStaticMethod', 'public')]]];
    }
}
