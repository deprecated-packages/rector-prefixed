<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type;

use InvalidArgumentException;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception\EmptyPhpSourceCode;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception\InvalidFileLocation;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
/**
 * This source locator simply parses the string given in the constructor as
 * valid PHP.
 *
 * Note that this source locator does NOT specify a filename, because we did
 * not load it from a file, so it will be null if you use this locator.
 */
class StringSourceLocator extends \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AbstractSourceLocator
{
    /** @var string */
    private $source;
    /**
     * @throws EmptyPhpSourceCode
     */
    public function __construct(string $source, \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator $astLocator)
    {
        parent::__construct($astLocator);
        if (empty($source)) {
            // Whilst an empty string is still "valid" PHP code, there is no
            // point in us even trying to parse it because we won't find what
            // we are looking for, therefore this throws an exception
            throw new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Exception\EmptyPhpSourceCode('Source code string was empty');
        }
        $this->source = $source;
    }
    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     * @throws InvalidFileLocation
     */
    protected function createLocatedSource(\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource
    {
        return new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource($this->source, null);
    }
}
