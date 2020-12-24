<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeMethodVisibilityRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBePublicMethod', 'public'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBeProtectedMethod', 'protected'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBePrivateMethod', 'private'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBePublicStaticMethod', 'public')]]];
    }
}
