<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\Behavior;

use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\RunnableRectorFactory;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @property-read RunnableRectorFactory $runnableRectorFactory
 */
trait RunnableTestTrait
{
    protected function assertOriginalAndFixedFileResultEquals(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo) : void
    {
        $runnable = $this->runnableRectorFactory->createRunnableClass($originalFileInfo);
        $expectedInstance = $this->runnableRectorFactory->createRunnableClass($expectedFileInfo);
        $actualResult = $runnable->run();
        $expectedResult = $expectedInstance->run();
        $this->assertSame($expectedResult, $actualResult);
    }
}
