<?php

declare (strict_types=1);
namespace PHPStan\DependencyInjection;

class DerivativeContainerFactory
{
    /** @var string */
    private $currentWorkingDirectory;
    /** @var string */
    private $tempDirectory;
    /** @var string[] */
    private $additionalConfigFiles;
    /** @var string[] */
    private $analysedPaths;
    /** @var string[] */
    private $composerAutoloaderProjectPaths;
    /** @var string[] */
    private $analysedPathsFromConfig;
    /** @var string */
    private $usedLevel;
    /** @var string|null */
    private $generateBaselineFile;
    /**
     * @param string $currentWorkingDirectory
     * @param string $tempDirectory
     * @param string[] $additionalConfigFiles
     * @param string[] $analysedPaths
     * @param string[] $composerAutoloaderProjectPaths
     * @param string[] $analysedPathsFromConfig
     * @param string $usedLevel
     */
    public function __construct(string $currentWorkingDirectory, string $tempDirectory, array $additionalConfigFiles, array $analysedPaths, array $composerAutoloaderProjectPaths, array $analysedPathsFromConfig, string $usedLevel, ?string $generateBaselineFile)
    {
        $this->currentWorkingDirectory = $currentWorkingDirectory;
        $this->tempDirectory = $tempDirectory;
        $this->additionalConfigFiles = $additionalConfigFiles;
        $this->analysedPaths = $analysedPaths;
        $this->composerAutoloaderProjectPaths = $composerAutoloaderProjectPaths;
        $this->analysedPathsFromConfig = $analysedPathsFromConfig;
        $this->usedLevel = $usedLevel;
        $this->generateBaselineFile = $generateBaselineFile;
    }
    /**
     * @param string[] $additionalConfigFiles
     * @return \PHPStan\DependencyInjection\Container
     */
    public function create(array $additionalConfigFiles) : \PHPStan\DependencyInjection\Container
    {
        $containerFactory = new \PHPStan\DependencyInjection\ContainerFactory($this->currentWorkingDirectory);
        return $containerFactory->create($this->tempDirectory, \array_merge($this->additionalConfigFiles, $additionalConfigFiles), $this->analysedPaths, $this->composerAutoloaderProjectPaths, $this->analysedPathsFromConfig, $this->usedLevel, $this->generateBaselineFile);
    }
}
