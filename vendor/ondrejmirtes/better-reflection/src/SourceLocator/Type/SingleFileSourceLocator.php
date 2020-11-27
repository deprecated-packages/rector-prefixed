<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Type;

use InvalidArgumentException;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Exception\InvalidFileLocation;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\FileChecker;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
use function file_get_contents;
/**
 * This source locator loads an entire file, specified in the constructor
 * argument.
 *
 * This is useful for loading a class that does not have a namespace. This is
 * also the class required if you want to use Reflector->getClassesFromFile
 * (which loads all classes from specified file)
 */
class SingleFileSourceLocator extends \_PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Type\AbstractSourceLocator
{
    /** @var string */
    private $fileName;
    /**
     * @throws InvalidFileLocation
     */
    public function __construct(string $fileName, \_PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Ast\Locator $astLocator)
    {
        \_PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\FileChecker::assertReadableFile($fileName);
        parent::__construct($astLocator);
        $this->fileName = $fileName;
    }
    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     * @throws InvalidFileLocation
     */
    protected function createLocatedSource(\_PhpScoper88fe6e0ad041\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Located\LocatedSource
    {
        return new \_PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Located\LocatedSource(\file_get_contents($this->fileName), $this->fileName);
    }
}
