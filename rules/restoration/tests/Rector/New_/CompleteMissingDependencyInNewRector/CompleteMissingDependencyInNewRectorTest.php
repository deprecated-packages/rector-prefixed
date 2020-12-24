<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Restoration\Tests\Rector\New_\CompleteMissingDependencyInNewRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Restoration\Rector\New_\CompleteMissingDependencyInNewRector;
use _PhpScopere8e811afab72\Rector\Restoration\Tests\Rector\New_\CompleteMissingDependencyInNewRector\Source\RandomDependency;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class CompleteMissingDependencyInNewRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Restoration\Rector\New_\CompleteMissingDependencyInNewRector::class => [\_PhpScopere8e811afab72\Rector\Restoration\Rector\New_\CompleteMissingDependencyInNewRector::CLASS_TO_INSTANTIATE_BY_TYPE => [\_PhpScopere8e811afab72\Rector\Restoration\Tests\Rector\New_\CompleteMissingDependencyInNewRector\Source\RandomDependency::class => \_PhpScopere8e811afab72\Rector\Restoration\Tests\Rector\New_\CompleteMissingDependencyInNewRector\Source\RandomDependency::class]]];
    }
}
