<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Ast\Strategy;

use PhpParser\Node;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\Reflection;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\ReflectionClass;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\ReflectionConstant;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\ReflectionFunction;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Reflector;
use _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
/**
 * @internal
 */
class NodeToReflection implements \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Ast\Strategy\AstConversionStrategy
{
    /**
     * Take an AST node in some located source (potentially in a namespace) and
     * convert it to a Reflection
     */
    public function __invoke(\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Reflector $reflector, \PhpParser\Node $node, \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, ?\PhpParser\Node\Stmt\Namespace_ $namespace, ?int $positionInNode = null) : ?\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\Reflection
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassLike) {
            return \_PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\ReflectionClass::createFromNode($reflector, $node, $locatedSource, $namespace);
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod || $node instanceof \PhpParser\Node\Stmt\Function_ || $node instanceof \PhpParser\Node\Expr\Closure) {
            return \_PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\ReflectionFunction::createFromNode($reflector, $node, $locatedSource, $namespace);
        }
        if ($node instanceof \PhpParser\Node\Stmt\Const_) {
            return \_PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\ReflectionConstant::createFromNode($reflector, $node, $locatedSource, $namespace, $positionInNode);
        }
        if ($node instanceof \PhpParser\Node\Expr\FuncCall) {
            try {
                return \_PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\ReflectionConstant::createFromNode($reflector, $node, $locatedSource);
            } catch (\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode $e) {
                // Ignore
            }
        }
        return null;
    }
}
