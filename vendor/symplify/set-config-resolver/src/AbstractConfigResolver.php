<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SetConfigResolver;

use _PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface;
use _PhpScopere8e811afab72\Symplify\SetConfigResolver\Console\Option\OptionName;
use _PhpScopere8e811afab72\Symplify\SetConfigResolver\Console\OptionValueResolver;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\Exception\FileNotFoundException;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
abstract class AbstractConfigResolver
{
    /**
     * @var SmartFileInfo|null
     */
    private $firstResolvedConfigFileInfo;
    /**
     * @var OptionValueResolver
     */
    private $optionValueResolver;
    public function __construct()
    {
        $this->optionValueResolver = new \_PhpScopere8e811afab72\Symplify\SetConfigResolver\Console\OptionValueResolver();
    }
    public function resolveFromInput(\_PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface $input) : ?\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo
    {
        $configValue = $this->optionValueResolver->getOptionValue($input, \_PhpScopere8e811afab72\Symplify\SetConfigResolver\Console\Option\OptionName::CONFIG);
        if ($configValue !== null) {
            if (!\file_exists($configValue)) {
                $message = \sprintf('File "%s" was not found', $configValue);
                throw new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\Exception\FileNotFoundException($message);
            }
            return $this->createFileInfo($configValue);
        }
        return null;
    }
    /**
     * @param string[] $fallbackFiles
     */
    public function resolveFromInputWithFallback(\_PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface $input, array $fallbackFiles) : ?\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo
    {
        $configFileInfo = $this->resolveFromInput($input);
        if ($configFileInfo !== null) {
            return $configFileInfo;
        }
        return $this->createFallbackFileInfoIfFound($fallbackFiles);
    }
    public function getFirstResolvedConfigFileInfo() : ?\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->firstResolvedConfigFileInfo;
    }
    /**
     * @param string[] $fallbackFiles
     */
    private function createFallbackFileInfoIfFound(array $fallbackFiles) : ?\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo
    {
        foreach ($fallbackFiles as $fallbackFile) {
            $rootFallbackFile = \getcwd() . \DIRECTORY_SEPARATOR . $fallbackFile;
            if (\is_file($rootFallbackFile)) {
                return $this->createFileInfo($rootFallbackFile);
            }
        }
        return null;
    }
    private function createFileInfo(string $configValue) : \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo
    {
        $configFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($configValue);
        $this->firstResolvedConfigFileInfo = $configFileInfo;
        return $configFileInfo;
    }
}
