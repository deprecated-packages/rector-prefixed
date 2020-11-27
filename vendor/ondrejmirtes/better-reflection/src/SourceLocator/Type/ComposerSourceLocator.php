<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Type;

use _PhpScoperbd5d0c5f7638\Composer\Autoload\ClassLoader;
use InvalidArgumentException;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Exception\InvalidFileLocation;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
use function file_get_contents;
/**
 * This source locator uses Composer's built-in ClassLoader to locate files.
 *
 * Note that we use ClassLoader->findFile directory, rather than
 * ClassLoader->loadClass because this library has a strict requirement that we
 * do NOT actually load the classes
 */
class ComposerSourceLocator extends \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Type\AbstractSourceLocator
{
    /** @var ClassLoader */
    private $classLoader;
    public function __construct(\_PhpScoperbd5d0c5f7638\Composer\Autoload\ClassLoader $classLoader, \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Ast\Locator $astLocator)
    {
        parent::__construct($astLocator);
        $this->classLoader = $classLoader;
    }
    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     * @throws InvalidFileLocation
     */
    protected function createLocatedSource(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource
    {
        if ($identifier->getType()->getName() !== \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CLASS) {
            return null;
        }
        $filename = $this->classLoader->findFile($identifier->getName());
        if (!$filename) {
            return null;
        }
        return new \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource(\file_get_contents($filename), $filename);
    }
}
