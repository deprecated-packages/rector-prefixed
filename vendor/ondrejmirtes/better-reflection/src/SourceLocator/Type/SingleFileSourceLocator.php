<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Type;

use InvalidArgumentException;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Exception\InvalidFileLocation;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\FileChecker;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
use function file_get_contents;
/**
 * This source locator loads an entire file, specified in the constructor
 * argument.
 *
 * This is useful for loading a class that does not have a namespace. This is
 * also the class required if you want to use Reflector->getClassesFromFile
 * (which loads all classes from specified file)
 */
class SingleFileSourceLocator extends \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Type\AbstractSourceLocator
{
    /** @var string */
    private $fileName;
    /**
     * @throws InvalidFileLocation
     */
    public function __construct(string $fileName, \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Ast\Locator $astLocator)
    {
        \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\FileChecker::assertReadableFile($fileName);
        parent::__construct($astLocator);
        $this->fileName = $fileName;
    }
    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     * @throws InvalidFileLocation
     */
    protected function createLocatedSource(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource
    {
        return new \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource(\file_get_contents($this->fileName), $this->fileName);
    }
}
