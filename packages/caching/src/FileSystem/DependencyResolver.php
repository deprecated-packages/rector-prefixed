<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Caching\FileSystem;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Dependency\DependencyResolver as PHPStanDependencyResolver;
use _PhpScoper0a2ac50786fa\PHPStan\File\FileHelper;
use _PhpScoper0a2ac50786fa\Rector\Core\Configuration\Configuration;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Configuration $configuration, \_PhpScoper0a2ac50786fa\PHPStan\Dependency\DependencyResolver $phpStanDependencyResolver, \_PhpScoper0a2ac50786fa\PHPStan\File\FileHelper $fileHelper)
    {
        $this->fileHelper = $fileHelper;
        $this->configuration = $configuration;
        $this->phpStanDependencyResolver = $phpStanDependencyResolver;
    }
    /**
     * @return string[]
     */
    public function resolveDependencies(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
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
