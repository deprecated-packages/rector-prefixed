<?php

declare (strict_types=1);
namespace RectorPrefix20210421\Symplify\EasyTesting\ValueObject;

use RectorPrefix20210421\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210421\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class ExpectedAndOutputFileInfoPair
{
    /**
     * @var SmartFileInfo
     */
    private $expectedFileInfo;
    /**
     * @var SmartFileInfo|null
     */
    private $outputFileInfo;
    /**
     * @param \Symplify\SmartFileSystem\SmartFileInfo|null $outputFileInfo
     */
    public function __construct(\RectorPrefix20210421\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo, $outputFileInfo)
    {
        $this->expectedFileInfo = $expectedFileInfo;
        $this->outputFileInfo = $outputFileInfo;
    }
    /**
     * @noRector \Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector
     */
    public function getExpectedFileContent() : string
    {
        return $this->expectedFileInfo->getContents();
    }
    /**
     * @noRector \Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector
     */
    public function getOutputFileContent() : string
    {
        if (!$this->outputFileInfo instanceof \RectorPrefix20210421\Symplify\SmartFileSystem\SmartFileInfo) {
            throw new \RectorPrefix20210421\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->outputFileInfo->getContents();
    }
    /**
     * @noRector \Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector
     */
    public function doesOutputFileExist() : bool
    {
        return $this->outputFileInfo !== null;
    }
}
