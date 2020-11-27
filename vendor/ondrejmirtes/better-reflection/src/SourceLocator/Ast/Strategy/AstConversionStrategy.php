<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Ast\Strategy;

use PhpParser\Node;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
/**
 * @internal
 */
interface AstConversionStrategy
{
    /**
     * Take an AST node in some located source (potentially in a namespace) and
     * convert it to something (concrete implementation decides)
     */
    public function __invoke(\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\Reflector $reflector, \PhpParser\Node $node, \_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, ?\PhpParser\Node\Stmt\Namespace_ $namespace, ?int $positionInNode = null) : ?\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Reflection;
}
