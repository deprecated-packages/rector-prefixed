<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\EasyTesting\ValueObject;

use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class InputFileInfoAndExpected
{
    /**
     * @var SmartFileInfo
     */
    private $inputFileInfo;
    /**
     * @var mixed
     */
    private $expected;
    /**
     * @param mixed $expected
     */
    public function __construct(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $inputFileInfo, $expected)
    {
        $this->inputFileInfo = $inputFileInfo;
        $this->expected = $expected;
    }
    public function getInputFileContent() : string
    {
        return $this->inputFileInfo->getContents();
    }
    public function getInputFileInfo() : \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->inputFileInfo;
    }
    public function getInputFileRealPath() : string
    {
        return $this->inputFileInfo->getRealPath();
    }
    /**
     * @return mixed
     */
    public function getExpected()
    {
        return $this->expected;
    }
}
