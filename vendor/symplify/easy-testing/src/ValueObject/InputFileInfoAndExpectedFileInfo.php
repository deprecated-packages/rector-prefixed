<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\EasyTesting\ValueObject;

use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class InputFileInfoAndExpectedFileInfo
{
    /**
     * @var SmartFileInfo
     */
    private $inputFileInfo;
    /**
     * @var SmartFileInfo
     */
    private $expectedFileInfo;
    public function __construct(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $inputFileInfo, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo)
    {
        $this->inputFileInfo = $inputFileInfo;
        $this->expectedFileInfo = $expectedFileInfo;
    }
    public function getInputFileInfo() : \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->inputFileInfo;
    }
    public function getExpectedFileInfo() : \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->expectedFileInfo;
    }
    public function getExpectedFileContent() : string
    {
        return $this->expectedFileInfo->getContents();
    }
    public function getExpectedFileInfoRealPath() : string
    {
        return $this->expectedFileInfo->getRealPath();
    }
}
