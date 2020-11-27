<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Ast\Strategy;

use PhpParser\Node;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
/**
 * @internal
 */
interface AstConversionStrategy
{
    /**
     * Take an AST node in some located source (potentially in a namespace) and
     * convert it to something (concrete implementation decides)
     */
    public function __invoke(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\Reflector $reflector, \PhpParser\Node $node, \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, ?\PhpParser\Node\Stmt\Namespace_ $namespace, ?int $positionInNode = null) : ?\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Reflection;
}
