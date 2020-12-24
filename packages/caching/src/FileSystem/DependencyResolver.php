<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Caching\FileSystem;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Dependency\DependencyResolver as PHPStanDependencyResolver;
use _PhpScopere8e811afab72\PHPStan\File\FileHelper;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Configuration;
final class DependencyResolver
{
    /**
     * @var FileHelper
     */
    private $fileHelper;
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var PHPStanDependencyResolver
     */
    private $phpStanDependencyResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\Configuration\Configuration $configuration, \_PhpScopere8e811afab72\PHPStan\Dependency\DependencyResolver $phpStanDependencyResolver, \_PhpScopere8e811afab72\PHPStan\File\FileHelper $fileHelper)
    {
        $this->fileHelper = $fileHelper;
        $this->configuration = $configuration;
        $this->phpStanDependencyResolver = $phpStanDependencyResolver;
    }
    /**
     * @return string[]
     */
    public function resolveDependencies(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $fileInfos = $this->configuration->getFileInfos();
        $analysedFileAbsolutesPaths = [];
        foreach ($fileInfos as $analysedFile) {
            $analysedFileAbsolutesPaths[] = $analysedFile->getRealPath();
        }
        $dependencyFiles = [];
        $nodeDependencies = $this->phpStanDependencyResolver->resolveDependencies($node, $scope);
        foreach ($nodeDependencies as $nodeDependency) {
            $dependencyFile = $nodeDependency->getFileName();
            if (!$dependencyFile) {
                continue;
            }
            $dependencyFile = $this->fileHelper->normalizePath($dependencyFile);
            if ($scope->getFile() === $dependencyFile) {
                continue;
            }
            if (!\in_array($dependencyFile, $analysedFileAbsolutesPaths, \true)) {
                continue;
            }
            $dependencyFiles[] = $dependencyFile;
        }
        $dependencyFiles = \array_unique($dependencyFiles, \SORT_STRING);
        return \array_values($dependencyFiles);
    }
}
