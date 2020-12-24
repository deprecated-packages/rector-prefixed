<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\Tests\Rector\Class_\AddEntityIdByConditionRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector;
use _PhpScopere8e811afab72\Rector\Doctrine\Tests\Rector\Class_\AddEntityIdByConditionRector\Source\SomeTrait;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class AddEntityIdByConditionRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::class => [\_PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::DETECTED_TRAITS => [\_PhpScopere8e811afab72\Rector\Doctrine\Tests\Rector\Class_\AddEntityIdByConditionRector\Source\SomeTrait::class]]];
    }
}
