<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Ast;

use Closure;
use PhpParser\Parser;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\FunctionReflector;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
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
        $this->findReflectionsInTree = new \_PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Ast\FindReflectionsInTree(new \_PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection(), $functionReflectorGetter);
        $this->parser = $parser;
    }
    /**
     * @throws IdentifierNotFound
     * @throws Exception\ParseToAstFailure
     */
    public function findReflection(\_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, \_PhpScoperabd03f0baf05\Roave\BetterReflection\Identifier\Identifier $identifier) : \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\Reflection
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
    public function findReflectionsOfType(\_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, \_PhpScoperabd03f0baf05\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        try {
            return $this->findReflectionsInTree->__invoke($reflector, $this->parser->parse($locatedSource->getSource()), $identifierType, $locatedSource);
        } catch (\Throwable $exception) {
            throw \_PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Ast\Exception\ParseToAstFailure::fromLocatedSource($locatedSource, $exception);
        }
    }
    /**
     * Given an array of Reflections, try to find the identifier.
     *
     * @param Reflection[] $reflections
     *
     * @throws IdentifierNotFound
     */
    private function findInArray(array $reflections, \_PhpScoperabd03f0baf05\Roave\BetterReflection\Identifier\Identifier $identifier) : \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\Reflection
    {
        $identifierName = \strtolower($identifier->getName());
        foreach ($reflections as $reflection) {
            if (\strtolower($reflection->getName()) === $identifierName) {
                return $reflection;
            }
        }
        throw \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound::fromIdentifier($identifier);
    }
}
