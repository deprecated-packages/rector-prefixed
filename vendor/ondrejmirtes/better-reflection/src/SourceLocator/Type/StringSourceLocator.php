<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Type;

use InvalidArgumentException;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Exception\EmptyPhpSourceCode;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Exception\InvalidFileLocation;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
/**
 * This source locator simply parses the string given in the constructor as
 * valid PHP.
 *
 * Note that this source locator does NOT specify a filename, because we did
 * not load it from a file, so it will be null if you use this locator.
 */
class StringSourceLocator extends \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Type\AbstractSourceLocator
{
    /** @var string */
    private $source;
    /**
     * @throws EmptyPhpSourceCode
     */
    public function __construct(string $source, \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Ast\Locator $astLocator)
    {
        parent::__construct($astLocator);
        if (empty($source)) {
            // Whilst an empty string is still "valid" PHP code, there is no
            // point in us even trying to parse it because we won't find what
            // we are looking for, therefore this throws an exception
            throw new \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Exception\EmptyPhpSourceCode('Source code string was empty');
        }
        $this->source = $source;
    }
    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     * @throws InvalidFileLocation
     */
    protected function createLocatedSource(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource
    {
        return new \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource($this->source, null);
    }
}
