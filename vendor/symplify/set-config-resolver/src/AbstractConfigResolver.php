<?php

declare (strict_types=1);
namespace RectorPrefix20210408\Symplify\SetConfigResolver;

use RectorPrefix20210408\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20210408\Symplify\SetConfigResolver\Console\Option\OptionName;
use RectorPrefix20210408\Symplify\SetConfigResolver\Console\OptionValueResolver;
use RectorPrefix20210408\Symplify\SmartFileSystem\Exception\FileNotFoundException;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
abstract class AbstractConfigResolver
{
    /**
     * @var OptionValueResolver
     */
    private $optionValueResolver;
    public function __construct()
    {
        $this->optionValueResolver = new \RectorPrefix20210408\Symplify\SetConfigResolver\Console\OptionValueResolver();
    }
    public function resolveFromInput(\RectorPrefix20210408\Symfony\Component\Console\Input\InputInterface $input) : ?\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo
    {
        $configValue = $this->optionValueResolver->getOptionValue($input, \RectorPrefix20210408\Symplify\SetConfigResolver\Console\Option\OptionName::CONFIG);
        if ($configValue !== null) {
            if (!\file_exists($configValue)) {
                $message = \sprintf('File "%s" was not found', $configValue);
                throw new \RectorPrefix20210408\Symplify\SmartFileSystem\Exception\FileNotFoundException($message);
            }
            return $this->createFileInfo($configValue);
        }
        return null;
    }
    /**
     * @param string[] $fallbackFiles
     */
    public function resolveFromInputWithFallback(\RectorPrefix20210408\Symfony\Component\Console\Input\InputInterface $input, array $fallbackFiles) : ?\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo
    {
        $configFileInfo = $this->resolveFromInput($input);
        if ($configFileInfo !== null) {
            return $configFileInfo;
        }
        return $this->createFallbackFileInfoIfFound($fallbackFiles);
    }
    /**
     * @param string[] $fallbackFiles
     */
    private function createFallbackFileInfoIfFound(array $fallbackFiles) : ?\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo
    {
        foreach ($fallbackFiles as $fallbackFile) {
            $rootFallbackFile = \getcwd() . \DIRECTORY_SEPARATOR . $fallbackFile;
            if (\is_file($rootFallbackFile)) {
                return $this->createFileInfo($rootFallbackFile);
            }
        }
        return null;
    }
    private function createFileInfo(string $configValue) : \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo($configValue);
    }
}
