<?php

declare (strict_types=1);
namespace PHPStan\Dependency;

use IteratorAggregate;
use PHPStan\File\FileHelper;
use PHPStan\Reflection\ReflectionWithFilename;
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
    public function __construct(\PHPStan\File\FileHelper $fileHelper, array $reflections, ?\PHPStan\Dependency\ExportedNode $exportedNode)
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
    public function getExportedNode() : ?\PHPStan\Dependency\ExportedNode
    {
        return $this->exportedNode;
    }
}
