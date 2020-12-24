<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Command;

use _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container;
use _PhpScoperb75b35f52b74\PHPStan\Internal\BytesHelper;
use function memory_get_peak_usage;
class InceptionResult
{
    /** @var callable(): (array{string[], bool}) */
    private $filesCallback;
    /** @var Output */
    private $stdOutput;
    /** @var Output */
    private $errorOutput;
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var bool */
    private $isDefaultLevelUsed;
    /** @var string */
    private $memoryLimitFile;
    /** @var string|null */
    private $projectConfigFile;
    /** @var mixed[]|null */
    private $projectConfigArray;
    /** @var string|null */
    private $generateBaselineFile;
    /**
     * @param callable(): (array{string[], bool}) $filesCallback
     * @param Output $stdOutput
     * @param Output $errorOutput
     * @param \PHPStan\DependencyInjection\Container $container
     * @param bool $isDefaultLevelUsed
     * @param string $memoryLimitFile
     * @param string|null $projectConfigFile
     * @param mixed[] $projectConfigArray
     * @param string|null $generateBaselineFile
     */
    public function __construct(callable $filesCallback, \_PhpScoperb75b35f52b74\PHPStan\Command\Output $stdOutput, \_PhpScoperb75b35f52b74\PHPStan\Command\Output $errorOutput, \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container $container, bool $isDefaultLevelUsed, string $memoryLimitFile, ?string $projectConfigFile, ?array $projectConfigArray, ?string $generateBaselineFile)
    {
        $this->filesCallback = $filesCallback;
        $this->stdOutput = $stdOutput;
        $this->errorOutput = $errorOutput;
        $this->container = $container;
        $this->isDefaultLevelUsed = $isDefaultLevelUsed;
        $this->memoryLimitFile = $memoryLimitFile;
        $this->projectConfigFile = $projectConfigFile;
        $this->projectConfigArray = $projectConfigArray;
        $this->generateBaselineFile = $generateBaselineFile;
    }
    /**
     * @return array{string[], bool}
     */
    public function getFiles() : array
    {
        $callback = $this->filesCallback;
        return $callback();
    }
    public function getStdOutput() : \_PhpScoperb75b35f52b74\PHPStan\Command\Output
    {
        return $this->stdOutput;
    }
    public function getErrorOutput() : \_PhpScoperb75b35f52b74\PHPStan\Command\Output
    {
        return $this->errorOutput;
    }
    public function getContainer() : \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container
    {
        return $this->container;
    }
    public function isDefaultLevelUsed() : bool
    {
        return $this->isDefaultLevelUsed;
    }
    public function getProjectConfigFile() : ?string
    {
        return $this->projectConfigFile;
    }
    /**
     * @return mixed[]|null
     */
    public function getProjectConfigArray() : ?array
    {
        return $this->projectConfigArray;
    }
    public function getGenerateBaselineFile() : ?string
    {
        return $this->generateBaselineFile;
    }
    public function handleReturn(int $exitCode) : int
    {
        if ($this->getErrorOutput()->isVerbose()) {
            $this->getErrorOutput()->writeLineFormatted(\sprintf('Used memory: %s', \_PhpScoperb75b35f52b74\PHPStan\Internal\BytesHelper::bytes(\memory_get_peak_usage(\true))));
        }
        @\unlink($this->memoryLimitFile);
        return $exitCode;
    }
}