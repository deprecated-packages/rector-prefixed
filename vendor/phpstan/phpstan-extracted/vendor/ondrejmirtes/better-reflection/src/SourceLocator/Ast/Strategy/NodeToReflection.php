<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
/**
 * @internal
 */
class NodeToReflection implements \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\AstConversionStrategy
{
    /**
     * Take an AST node in some located source (potentially in a namespace) and
     * convert it to a Reflection
     */
    public function __invoke(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_ $namespace, ?int $positionInNode = null) : ?\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
            return \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass::createFromNode($reflector, $node, $locatedSource, $namespace);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_ || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure) {
            return \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction::createFromNode($reflector, $node, $locatedSource, $namespace);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Const_) {
            return \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant::createFromNode($reflector, $node, $locatedSource, $namespace, $positionInNode);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            try {
                return \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant::createFromNode($reflector, $node, $locatedSource);
            } catch (\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode $e) {
                // Ignore
            }
        }
        return null;
    }
}
