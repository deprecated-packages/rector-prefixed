<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\Expression\MethodCallToReturnRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector\Source\ReturnDeny;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\MethodCallToReturn;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallToReturnRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\Expression\MethodCallToReturnRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\Expression\MethodCallToReturnRector::METHOD_CALL_WRAPS => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\MethodCallToReturn(\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector\Source\ReturnDeny::class, 'deny')]]];
    }
}
