<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\Behavior;

use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\RunnableRectorFactory;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @property-read RunnableRectorFactory $runnableRectorFactory
 */
trait RunnableTestTrait
{
    protected function assertOriginalAndFixedFileResultEquals(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo) : void
    {
        $runnable = $this->runnableRectorFactory->createRunnableClass($originalFileInfo);
        $expectedInstance = $this->runnableRectorFactory->createRunnableClass($expectedFileInfo);
        $actualResult = $runnable->run();
        $expectedResult = $expectedInstance->run();
        $this->assertSame($expectedResult, $actualResult);
    }
}
