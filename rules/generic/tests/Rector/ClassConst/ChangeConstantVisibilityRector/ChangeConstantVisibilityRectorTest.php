<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassConst\ChangeConstantVisibilityRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ClassConstantVisibilityChange;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeConstantVisibilityRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassConst\ChangeConstantVisibilityRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassConst\ChangeConstantVisibilityRector::CLASS_CONSTANT_VISIBILITY_CHANGES => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ClassConstantVisibilityChange(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PUBLIC_CONSTANT', 'public'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ClassConstantVisibilityChange(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PROTECTED_CONSTANT', 'protected'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ClassConstantVisibilityChange(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PRIVATE_CONSTANT', 'private'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ClassConstantVisibilityChange('_PhpScopere8e811afab72\\Rector\\Generic\\Tests\\Rector\\ClassConst\\ChangeConstantVisibilityRector\\Fixture\\Fixture2', 'TO_BE_PRIVATE_CONSTANT', 'private')]]];
    }
}
