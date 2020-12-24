<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\WrapReturnRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\WrapReturnRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\WrapReturnRector\Source\SomeReturnClass;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\WrapReturn;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class WrapReturnRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\WrapReturnRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\WrapReturnRector::TYPE_METHOD_WRAPS => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\WrapReturn(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\WrapReturnRector\Source\SomeReturnClass::class, 'getItem', \true)]]];
    }
}
