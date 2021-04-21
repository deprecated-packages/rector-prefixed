<?php

declare(strict_types=1);

namespace Rector\Core\Configuration;

use Jean85\PrettyVersions;
use Nette\Utils\Strings;
use Rector\ChangesReporting\Output\ConsoleOutputFormatter;
use Rector\Core\Exception\Configuration\InvalidConfigurationException;
use Rector\Core\ValueObject\Bootstrap\BootstrapConfigs;
use Symfony\Component\Console\Input\InputInterface;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SmartFileSystem\SmartFileInfo;

final class Configuration
{
    /**
     * @var bool
     */
    private $isDryRun = false;

    /**
     * @var bool
     */
    private $showProgressBar = true;

    /**
     * @var bool
     */
    private $shouldClearCache = false;

    /**
     * @var string
     */
    private $outputFormat;

    /**
     * @var bool
     */
    private $isCacheDebug = false;

    /**
     * @var bool
     */
    private $isCacheEnabled = false;

    /**
     * @var string[]
     */
    private $fileExtensions = [];

    /**
     * @var string[]
     */
    private $paths = [];

    /**
     * @var ParameterProvider
     */
    private $parameterProvider;

    /**
     * @var string|null
     */
    private $outputFile;

    /**
     * @var bool
     */
    private $showDiffs = true;

    /**
     * @var BootstrapConfigs|null
     */
    private $bootstrapConfigs;

    public function __construct(ParameterProvider $parameterProvider)
    {
        $this->isCacheEnabled = (bool) $parameterProvider->provideParameter(Option::ENABLE_CACHE);
        $this->fileExtensions = (array) $parameterProvider->provideParameter(Option::FILE_EXTENSIONS);
        $this->paths = (array) $parameterProvider->provideParameter(Option::PATHS);
        $this->parameterProvider = $parameterProvider;
    }

    /**
     * Needs to run in the start of the life cycle, since the rest of workflow uses it.
     * @return void
     */
    public function resolveFromInput(InputInterface $input)
    {
        $this->isDryRun = (bool) $input->getOption(Option::OPTION_DRY_RUN);
        $this->shouldClearCache = (bool) $input->getOption(Option::OPTION_CLEAR_CACHE);

        $this->showProgressBar = $this->canShowProgressBar($input);
        $this->showDiffs = ! (bool) $input->getOption(Option::OPTION_NO_DIFFS);
        $this->isCacheDebug = (bool) $input->getOption(Option::CACHE_DEBUG);

        /** @var string|null $outputFileOption */
        $outputFileOption = $input->getOption(Option::OPTION_OUTPUT_FILE);
        $this->outputFile = $this->sanitizeOutputFileValue($outputFileOption);

        $this->outputFormat = (string) $input->getOption(Option::OPTION_OUTPUT_FORMAT);

        $commandLinePaths = (array) $input->getArgument(Option::SOURCE);

        // manual command line value has priority
        if ($commandLinePaths !== []) {
            $commandLinePaths = $this->correctBashSpacePaths($commandLinePaths);
            $this->paths = $commandLinePaths;
        }
    }

    public function getPrettyVersion(): string
    {
        $version = PrettyVersions::getVersion('rector/rector');
        return $version->getPrettyVersion();
    }

    /**
     * @forTests
     * @return void
     */
    public function setIsDryRun(bool $isDryRun)
    {
        $this->isDryRun = $isDryRun;
    }

    public function isDryRun(): bool
    {
        return $this->isDryRun;
    }

    public function shouldShowProgressBar(): bool
    {
        if ($this->isCacheDebug) {
            return false;
        }

        return $this->showProgressBar;
    }

    /**
     * @return string|null
     */
    public function getOutputFile()
    {
        return $this->outputFile;
    }

    public function shouldClearCache(): bool
    {
        return $this->shouldClearCache;
    }

    public function isCacheDebug(): bool
    {
        return $this->isCacheDebug;
    }

    public function isCacheEnabled(): bool
    {
        return $this->isCacheEnabled;
    }

    /**
     * @return string[]
     */
    public function getFileExtensions(): array
    {
        return $this->fileExtensions;
    }

    /**
     * @return string[]
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    public function getOutputFormat(): string
    {
        return $this->outputFormat;
    }

    /**
     * @return void
     */
    public function validateConfigParameters()
    {
        $symfonyContainerXmlPath = (string) $this->parameterProvider->provideParameter(
            Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER
        );
        if ($symfonyContainerXmlPath === '') {
            return;
        }

        if (file_exists($symfonyContainerXmlPath)) {
            return;
        }

        $message = sprintf(
            'Path "%s" for "$parameters->set(Option::%s, ...);" in your config was not found. Correct it',
            $symfonyContainerXmlPath,
            'SYMFONY_CONTAINER_XML_PATH_PARAMETER'
        );
        throw new InvalidConfigurationException($message);
    }

    public function shouldHideClutter(): bool
    {
        return $this->outputFormat !== ConsoleOutputFormatter::NAME;
    }

    public function shouldShowDiffs(): bool
    {
        return $this->showDiffs;
    }

    /**
     * @return void
     */
    public function setBootstrapConfigs(BootstrapConfigs $bootstrapConfigs)
    {
        $this->bootstrapConfigs = $bootstrapConfigs;
    }

    /**
     * @return string|null
     */
    public function getMainConfigFilePath()
    {
        if ($this->bootstrapConfigs === null) {
            return null;
        }

        $mainConfigFileInfo = $this->bootstrapConfigs->getMainConfigFileInfo();
        if (! $mainConfigFileInfo instanceof SmartFileInfo) {
            return null;
        }

        return $mainConfigFileInfo->getRelativeFilePathFromCwd();
    }

    private function canShowProgressBar(InputInterface $input): bool
    {
        $noProgressBar = (bool) $input->getOption(Option::OPTION_NO_PROGRESS_BAR);
        if ($noProgressBar) {
            return false;
        }

        $optionOutputFormat = $input->getOption(Option::OPTION_OUTPUT_FORMAT);
        return $optionOutputFormat === ConsoleOutputFormatter::NAME;
    }

    /**
     * @param string|null $outputFileOption
     * @return string|null
     */
    private function sanitizeOutputFileValue($outputFileOption)
    {
        if ($outputFileOption === '') {
            return null;
        }

        return $outputFileOption;
    }

    /**
     * @param string[] $commandLinePaths
     * @return string[]
     */
    private function correctBashSpacePaths(array $commandLinePaths): array
    {
        // fixes bash edge-case that to merges string with space to one
        foreach ($commandLinePaths as $commandLinePath) {
            if (Strings::contains($commandLinePath, ' ')) {
                $commandLinePaths = explode(' ', $commandLinePath);
            }
        }

        return $commandLinePaths;
    }
}
