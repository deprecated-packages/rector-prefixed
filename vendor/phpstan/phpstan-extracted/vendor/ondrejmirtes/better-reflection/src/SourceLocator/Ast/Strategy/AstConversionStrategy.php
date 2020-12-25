<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy;

use PhpParser\Node;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
/**
 * @internal
 */
interface AstConversionStrategy
{
    /**
     * Take an AST node in some located source (potentially in a namespace) and
     * convert it to something (concrete implementation decides)
     */
    public function __invoke(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \PhpParser\Node $node, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, ?\PhpParser\Node\Stmt\Namespace_ $namespace, ?int $positionInNode = null) : ?\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
}
