<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Testing\PHPUnit\Behavior;

use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\RunnableRectorFactory;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @property-read RunnableRectorFactory $runnableRectorFactory
 */
trait RunnableTestTrait
{
    protected function assertOriginalAndFixedFileResultEquals(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo) : void
    {
        $runnable = $this->runnableRectorFactory->createRunnableClass($originalFileInfo);
        $expectedInstance = $this->runnableRectorFactory->createRunnableClass($expectedFileInfo);
        $actualResult = $runnable->run();
        $expectedResult = $expectedInstance->run();
        $this->assertSame($expectedResult, $actualResult);
    }
}
