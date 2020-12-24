<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Dependency;

use IteratorAggregate;
use _PhpScopere8e811afab72\PHPStan\File\FileHelper;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionWithFilename;
/**
 * @implements \IteratorAggregate<int, ReflectionWithFilename>
 */
class NodeDependencies implements \IteratorAggregate
{
    /** @var FileHelper */
    private $fileHelper;
    /** @var ReflectionWithFilename[] */
    private $reflections;
    /** @var ExportedNode|null */
    private $exportedNode;
    /**
     * @param FileHelper $fileHelper
     * @param ReflectionWithFilename[] $reflections
     */
    public function __construct(\_PhpScopere8e811afab72\PHPStan\File\FileHelper $fileHelper, array $reflections, ?\_PhpScopere8e811afab72\PHPStan\Dependency\ExportedNode $exportedNode)
    {
        $this->fileHelper = $fileHelper;
        $this->reflections = $reflections;
        $this->exportedNode = $exportedNode;
    }
    public function getIterator() : \Traversable
    {
        return new \ArrayIterator($this->reflections);
    }
    /**
     * @param string $currentFile
     * @param array<string, true> $analysedFiles
     * @return string[]
     */
    public function getFileDependencies(string $currentFile, array $analysedFiles) : array
    {
        $dependencies = [];
        foreach ($this->reflections as $dependencyReflection) {
            $dependencyFile = $dependencyReflection->getFileName();
            if ($dependencyFile === \false) {
                continue;
            }
            $dependencyFile = $this->fileHelper->normalizePath($dependencyFile);
            if ($currentFile === $dependencyFile) {
                continue;
            }
            if (!isset($analysedFiles[$dependencyFile])) {
                continue;
            }
            $dependencies[$dependencyFile] = $dependencyFile;
        }
        return \array_values($dependencies);
    }
    public function getExportedNode() : ?\_PhpScopere8e811afab72\PHPStan\Dependency\ExportedNode
    {
        return $this->exportedNode;
    }
}
