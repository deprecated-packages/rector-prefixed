<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Ast\Strategy;

use PhpParser\Node;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionClass;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionConstant;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionFunction;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
/**
 * @internal
 */
class NodeToReflection implements \_PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Ast\Strategy\AstConversionStrategy
{
    /**
     * Take an AST node in some located source (potentially in a namespace) and
     * convert it to a Reflection
     */
    public function __invoke(\_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\Reflector $reflector, \PhpParser\Node $node, \_PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, ?\PhpParser\Node\Stmt\Namespace_ $namespace, ?int $positionInNode = null) : ?\_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\Reflection
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassLike) {
            return \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionClass::createFromNode($reflector, $node, $locatedSource, $namespace);
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod || $node instanceof \PhpParser\Node\Stmt\Function_ || $node instanceof \PhpParser\Node\Expr\Closure) {
            return \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionFunction::createFromNode($reflector, $node, $locatedSource, $namespace);
        }
        if ($node instanceof \PhpParser\Node\Stmt\Const_) {
            return \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionConstant::createFromNode($reflector, $node, $locatedSource, $namespace, $positionInNode);
        }
        if ($node instanceof \PhpParser\Node\Expr\FuncCall) {
            try {
                return \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionConstant::createFromNode($reflector, $node, $locatedSource);
            } catch (\_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode $e) {
                // Ignore
            }
        }
        return null;
    }
}
