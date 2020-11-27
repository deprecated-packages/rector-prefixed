<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Type;

use Iterator;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Exception\InvalidFileInfo;
use _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Exception\InvalidFileLocation;
use SplFileInfo;
use function array_filter;
use function array_map;
use function array_values;
use function iterator_to_array;
use function pathinfo;
use const PATHINFO_EXTENSION;
/**
 * This source locator loads all php files from \FileSystemIterator
 */
class FileIteratorSourceLocator implements \_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var AggregateSourceLocator|null */
    private $aggregateSourceLocator;
    /** @var Iterator|SplFileInfo[] */
    private $fileSystemIterator;
    /** @var Locator */
    private $astLocator;
    /**
     * @param Iterator|SplFileInfo[] $fileInfoIterator note: only SplFileInfo allowed in this iterator
     *
     * @throws InvalidFileInfo In case of iterator not contains only SplFileInfo.
     */
    public function __construct(\Iterator $fileInfoIterator, \_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Ast\Locator $astLocator)
    {
        foreach ($fileInfoIterator as $fileInfo) {
            if (!$fileInfo instanceof \SplFileInfo) {
                throw \_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Exception\InvalidFileInfo::fromNonSplFileInfo($fileInfo);
            }
        }
        $this->fileSystemIterator = $fileInfoIterator;
        $this->astLocator = $astLocator;
    }
    /**
     * @throws InvalidFileLocation
     */
    private function getAggregatedSourceLocator() : \_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator
    {
        return $this->aggregateSourceLocator ?: new \_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator(\array_values(\array_filter(\array_map(function (\SplFileInfo $item) : ?SingleFileSourceLocator {
            if (!($item->isFile() && \pathinfo($item->getRealPath(), \PATHINFO_EXTENSION) === 'php')) {
                return null;
            }
            return new \_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Type\SingleFileSourceLocator($item->getRealPath(), $this->astLocator);
        }, \iterator_to_array($this->fileSystemIterator)))));
    }
    /**
     * {@inheritDoc}
     *
     * @throws InvalidFileLocation
     */
    public function locateIdentifier(\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Reflection
    {
        return $this->getAggregatedSourceLocator()->locateIdentifier($reflector, $identifier);
    }
    /**
     * {@inheritDoc}
     *
     * @throws InvalidFileLocation
     */
    public function locateIdentifiersByType(\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return $this->getAggregatedSourceLocator()->locateIdentifiersByType($reflector, $identifierType);
    }
}
