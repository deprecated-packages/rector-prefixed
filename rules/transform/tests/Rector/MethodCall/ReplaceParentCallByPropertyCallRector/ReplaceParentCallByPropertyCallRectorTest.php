<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\MethodCall\ReplaceParentCallByPropertyCallRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector;
use _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\MethodCall\ReplaceParentCallByPropertyCallRector\Source\TypeClassToReplaceMethodCallBy;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ReplaceParentCallByPropertyCallRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector::class => [\_PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector::PARENT_CALLS_TO_PROPERTIES => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall(\_PhpScopere8e811afab72\Rector\Transform\Tests\Rector\MethodCall\ReplaceParentCallByPropertyCallRector\Source\TypeClassToReplaceMethodCallBy::class, 'someMethod', 'someProperty')]]];
    }
}
