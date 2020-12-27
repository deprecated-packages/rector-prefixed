<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Methods;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class CallToConstructorStatementWithoutSideEffectsRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->expr instanceof \PhpParser\Node\Expr\New_) {
            return [];
        }
        $instantiation = $node->expr;
        if (!$instantiation->class instanceof \PhpParser\Node\Name) {
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
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s::%s() on a separate line has no effect.', $classReflection->getDisplayName(), $constructor->getName()))->build()];
        }
        return [];
    }
}
