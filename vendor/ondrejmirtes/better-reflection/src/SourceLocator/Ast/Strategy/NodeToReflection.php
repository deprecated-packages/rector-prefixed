<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Ast\Strategy;

use PhpParser\Node;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionClass;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionConstant;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionFunction;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
/**
 * @internal
 */
class NodeToReflection implements \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Ast\Strategy\AstConversionStrategy
{
    /**
     * Take an AST node in some located source (potentially in a namespace) and
     * convert it to a Reflection
     */
    public function __invoke(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\Reflector $reflector, \PhpParser\Node $node, \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, ?\PhpParser\Node\Stmt\Namespace_ $namespace, ?int $positionInNode = null) : ?\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Reflection
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassLike) {
            return \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionClass::createFromNode($reflector, $node, $locatedSource, $namespace);
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod || $node instanceof \PhpParser\Node\Stmt\Function_ || $node instanceof \PhpParser\Node\Expr\Closure) {
            return \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionFunction::createFromNode($reflector, $node, $locatedSource, $namespace);
        }
        if ($node instanceof \PhpParser\Node\Stmt\Const_) {
            return \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionConstant::createFromNode($reflector, $node, $locatedSource, $namespace, $positionInNode);
        }
        if ($node instanceof \PhpParser\Node\Expr\FuncCall) {
            try {
                return \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionConstant::createFromNode($reflector, $node, $locatedSource);
            } catch (\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode $e) {
                // Ignore
            }
        }
        return null;
    }
}
