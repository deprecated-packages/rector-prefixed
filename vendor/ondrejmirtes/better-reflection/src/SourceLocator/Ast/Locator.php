<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Ast;

use Closure;
use PhpParser\Parser;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\Reflection;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\FunctionReflector;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Reflector;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
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
    public function __construct(\PhpParser\Parser $parser, \Closure $functionReflectorGetter)
    {
        $this->findReflectionsInTree = new \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Ast\FindReflectionsInTree(new \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection(), $functionReflectorGetter);
        $this->parser = $parser;
    }
    /**
     * @throws IdentifierNotFound
     * @throws Exception\ParseToAstFailure
     */
    public function findReflection(\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, \_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier $identifier) : \_PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\Reflection
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
    public function findReflectionsOfType(\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, \_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        try {
            return $this->findReflectionsInTree->__invoke($reflector, $this->parser->parse($locatedSource->getSource()), $identifierType, $locatedSource);
        } catch (\Throwable $exception) {
            throw \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Ast\Exception\ParseToAstFailure::fromLocatedSource($locatedSource, $exception);
        }
    }
    /**
     * Given an array of Reflections, try to find the identifier.
     *
     * @param Reflection[] $reflections
     *
     * @throws IdentifierNotFound
     */
    private function findInArray(array $reflections, \_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier $identifier) : \_PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\Reflection
    {
        $identifierName = \strtolower($identifier->getName());
        foreach ($reflections as $reflection) {
            if (\strtolower($reflection->getName()) === $identifierName) {
                return $reflection;
            }
        }
        throw \_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound::fromIdentifier($identifier);
    }
}
