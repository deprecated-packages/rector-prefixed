<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast;

use Closure;
use _PhpScoper0a2ac50786fa\PhpParser\Parser;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
use Throwable;
use function strtolower;
/**
 * @internal
 */
class Locator
{
    /** @var FindReflectionsInTree */
    private $findReflectionsInTree;
    /** @var Parser */
    private $parser;
    /**
     * @param Closure(): FunctionReflector $functionReflectorGetter
     */
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Parser $parser, \Closure $functionReflectorGetter)
    {
        $this->findReflectionsInTree = new \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\FindReflectionsInTree(new \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection(), $functionReflectorGetter);
        $this->parser = $parser;
    }
    /**
     * @throws IdentifierNotFound
     * @throws Exception\ParseToAstFailure
     */
    public function findReflection(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        return $this->findInArray($this->findReflectionsOfType($reflector, $locatedSource, $identifier->getType()), $identifier);
    }
    /**
     * Get an array of reflections found in some code.
     *
     * @return Reflection[]
     *
     * @throws Exception\ParseToAstFailure
     */
    public function findReflectionsOfType(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        try {
            return $this->findReflectionsInTree->__invoke($reflector, $this->parser->parse($locatedSource->getSource()), $identifierType, $locatedSource);
        } catch (\Throwable $exception) {
            throw \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Exception\ParseToAstFailure::fromLocatedSource($locatedSource, $exception);
        }
    }
    /**
     * Given an array of Reflections, try to find the identifier.
     *
     * @param Reflection[] $reflections
     *
     * @throws IdentifierNotFound
     */
    private function findInArray(array $reflections, \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        $identifierName = \strtolower($identifier->getName());
        foreach ($reflections as $reflection) {
            if (\strtolower($reflection->getName()) === $identifierName) {
                return $reflection;
            }
        }
        throw \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound::fromIdentifier($identifier);
    }
}
