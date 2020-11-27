<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type\Composer;

use _PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\Reflection;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Reflector;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type\Composer\Psr\PsrAutoloaderMapping;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type\DirectoriesSourceLocator;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
use function file_exists;
use function file_get_contents;
final class PsrAutoloaderLocator implements \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var PsrAutoloaderMapping */
    private $mapping;
    /** @var Locator */
    private $astLocator;
    public function __construct(\_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type\Composer\Psr\PsrAutoloaderMapping $mapping, \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Ast\Locator $astLocator)
    {
        $this->mapping = $mapping;
        $this->astLocator = $astLocator;
    }
    public function locateIdentifier(\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\Reflection
    {
        foreach ($this->mapping->resolvePossibleFilePaths($identifier) as $file) {
            if (!\file_exists($file)) {
                continue;
            }
            try {
                return $this->astLocator->findReflection($reflector, new \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Located\LocatedSource(\file_get_contents($file), $file), $identifier);
            } catch (\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $exception) {
                // on purpose - autoloading is allowed to fail, and silently-failing autoloaders are normal/endorsed
            }
        }
        return null;
    }
    /**
     * Find all identifiers of a type
     *
     * @return Reflection[]
     */
    public function locateIdentifiersByType(\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return (new \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type\DirectoriesSourceLocator($this->mapping->directories(), $this->astLocator))->locateIdentifiersByType($reflector, $identifierType);
    }
}
