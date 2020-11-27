<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type;

use _PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\Reflection;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Reflector;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Ast\Exception\ParseToAstFailure;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Ast\Locator as AstLocator;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
abstract class AbstractSourceLocator implements \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var AstLocator */
    private $astLocator;
    /**
     * Children should implement this method and return a LocatedSource object
     * which contains the source and the file from which it was located.
     *
     * @example
     *   return new LocatedSource(['<?php class Foo {}', null]);
     *   return new LocatedSource([\file_get_contents('Foo.php'), 'Foo.php']);
     */
    protected abstract function createLocatedSource(\_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
    public function __construct(\_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Ast\Locator $astLocator)
    {
        $this->astLocator = $astLocator;
    }
    /**
     * {@inheritDoc}
     *
     * @throws ParseToAstFailure
     */
    public function locateIdentifier(\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\Reflection
    {
        $locatedSource = $this->createLocatedSource($identifier);
        if (!$locatedSource) {
            return null;
        }
        try {
            return $this->astLocator->findReflection($reflector, $locatedSource, $identifier);
        } catch (\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $exception) {
            return null;
        }
    }
    /**
     * {@inheritDoc}
     *
     * @throws ParseToAstFailure
     */
    public final function locateIdentifiersByType(\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        $locatedSource = $this->createLocatedSource(new \_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier(\_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier::WILDCARD, $identifierType));
        if (!$locatedSource) {
            return [];
        }
        return $this->astLocator->findReflectionsOfType($reflector, $locatedSource, $identifierType);
    }
}
