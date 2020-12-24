<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Methods;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class CallToConstructorStatementWithoutSideEffectsRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_) {
            return [];
        }
        $instantiation = $node->expr;
        if (!$instantiation->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
            return [];
        }
        $className = $scope->resolveName($instantiation->class);
        if (!$this->reflectionProvider->hasClass($className)) {
            return [];
        }
        $classReflection = $this->reflectionProvider->getClass($className);
        if (!$classReflection->hasConstructor()) {
            return [];
        }
        $constructor = $classReflection->getConstructor();
        if ($constructor->hasSideEffects()->no()) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s::%s() on a separate line has no effect.', $classReflection->getDisplayName(), $constructor->getName()))->build()];
        }
        return [];
    }
}
