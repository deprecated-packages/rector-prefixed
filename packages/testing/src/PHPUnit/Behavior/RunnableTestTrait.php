<?php

declare (strict_types=1);
namespace Rector\Testing\PHPUnit\Behavior;

use Rector\Testing\PHPUnit\RunnableRectorFactory;
use RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @property-read RunnableRectorFactory $runnableRectorFactory
 */
trait RunnableTestTrait
{
    protected function assertOriginalAndFixedFileResultEquals(\RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, \RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo) : void
    {
        $runnable = $this->runnableRectorFactory->createRunnableClass($originalFileInfo);
        $expectedInstance = $this->runnableRectorFactory->createRunnableClass($expectedFileInfo);
        $actualResult = $runnable->run();
        $expectedResult = $expectedInstance->run();
        $this->assertSame($expectedResult, $actualResult);
    }
}
