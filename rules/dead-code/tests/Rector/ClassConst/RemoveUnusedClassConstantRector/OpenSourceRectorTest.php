<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Tests\Rector\ClassConst\RemoveUnusedClassConstantRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\ProjectType;
use _PhpScopere8e811afab72\Rector\DeadCode\Rector\ClassConst\RemoveUnusedClassConstantRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class OpenSourceRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::PROJECT_TYPE, \_PhpScopere8e811afab72\Rector\Core\ValueObject\ProjectType::OPEN_SOURCE);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureOpenSource');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\DeadCode\Rector\ClassConst\RemoveUnusedClassConstantRector::class;
    }
}
