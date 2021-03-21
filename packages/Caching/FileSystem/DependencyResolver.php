<?php

declare (strict_types=1);
namespace Rector\Caching\FileSystem;

use PhpParser\Node;
use PHPStan\Analyser\MutatingScope;
use PHPStan\Dependency\DependencyResolver as PHPStanDependencyResolver;
use PHPStan\File\FileHelper;
use Rector\Core\Configuration\Configuration;
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
    public function __construct(\Rector\Core\Configuration\Configuration $configuration, \PHPStan\Dependency\DependencyResolver $phpStanDependencyResolver, \PHPStan\File\FileHelper $fileHelper)
    {
        $this->fileHelper = $fileHelper;
        $this->configuration = $configuration;
        $this->phpStanDependencyResolver = $phpStanDependencyResolver;
    }
    /**
     * @return string[]
     */
    public function resolveDependencies(\PhpParser\Node $node, \PHPStan\Analyser\MutatingScope $mutatingScope) : array
    {
        $fileInfos = $this->configuration->getFileInfos();
        $analysedFileAbsolutesPaths = [];
        foreach ($fileInfos as $fileInfo) {
            $analysedFileAbsolutesPaths[] = $fileInfo->getRealPath();
        }
        $dependencyFiles = [];
        $nodeDependencies = $this->phpStanDependencyResolver->resolveDependencies($node, $mutatingScope);
        foreach ($nodeDependencies as $nodeDependency) {
            $dependencyFile = $nodeDependency->getFileName();
            if (!$dependencyFile) {
                continue;
            }
            $dependencyFile = $this->fileHelper->normalizePath($dependencyFile);
            if ($mutatingScope->getFile() === $dependencyFile) {
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
