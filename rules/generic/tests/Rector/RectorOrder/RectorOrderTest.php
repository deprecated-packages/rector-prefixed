<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\RectorOrder;

use Iterator;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector;
use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * Covers https://github.com/rectorphp/rector/pull/266#issuecomment-355725764
 */
final class RectorOrderTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        // order matters
        return [\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertComparisonToSpecificMethodRector::class => [], \_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector::class => [], \_PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall\AssertFalseStrposToContainsRector::class => []];
    }
}
