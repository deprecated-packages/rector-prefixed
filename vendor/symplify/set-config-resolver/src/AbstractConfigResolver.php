<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\SetConfigResolver;

use _PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputInterface;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Console\Option\OptionName;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Console\OptionValueResolver;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Exception\FileNotFoundException;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
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
        $this->optionValueResolver = new \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Console\OptionValueResolver();
    }
    public function resolveFromInput(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputInterface $input) : ?\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo
    {
        $configValue = $this->optionValueResolver->getOptionValue($input, \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Console\Option\OptionName::CONFIG);
        if ($configValue !== null) {
            if (!\file_exists($configValue)) {
                $message = \sprintf('File "%s" was not found', $configValue);
                throw new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Exception\FileNotFoundException($message);
            }
            return $this->createFileInfo($configValue);
        }
        return null;
    }
    /**
     * @param string[] $fallbackFiles
     */
    public function resolveFromInputWithFallback(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputInterface $input, array $fallbackFiles) : ?\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo
    {
        $configFileInfo = $this->resolveFromInput($input);
        if ($configFileInfo !== null) {
            return $configFileInfo;
        }
        return $this->createFallbackFileInfoIfFound($fallbackFiles);
    }
    public function getFirstResolvedConfigFileInfo() : ?\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->firstResolvedConfigFileInfo;
    }
    /**
     * @param string[] $fallbackFiles
     */
    private function createFallbackFileInfoIfFound(array $fallbackFiles) : ?\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo
    {
        foreach ($fallbackFiles as $fallbackFile) {
            $rootFallbackFile = \getcwd() . \DIRECTORY_SEPARATOR . $fallbackFile;
            if (\is_file($rootFallbackFile)) {
                return $this->createFileInfo($rootFallbackFile);
            }
        }
        return null;
    }
    private function createFileInfo(string $configValue) : \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo
    {
        $configFileInfo = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo($configValue);
        $this->firstResolvedConfigFileInfo = $configFileInfo;
        return $configFileInfo;
    }
}
