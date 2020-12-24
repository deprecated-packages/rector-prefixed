<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector;

use Iterator;
use _PhpScopere8e811afab72\PHPUnit\Framework\TestCase;
use _PhpScopere8e811afab72\Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector;
use _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector\Source\AbstractTestCase;
use _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector\Source\BeLocalClass;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class PreferThisOrSelfMethodCallRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector::class => [\_PhpScopere8e811afab72\Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector::TYPE_TO_PREFERENCE => [\_PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector\Source\AbstractTestCase::class => 'self', \_PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector\Source\BeLocalClass::class => 'this', \_PhpScopere8e811afab72\PHPUnit\Framework\TestCase::class => 'self']]];
    }
}
