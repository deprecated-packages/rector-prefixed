<?php

declare(strict_types=1);

namespace Rector\NodeCollector\ScopeResolver;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use Rector\NodeTypeResolver\Node\AttributeKey;

final class ParentClassScopeResolver
{
    /**
     * @return string|null
     */
    public function resolveParentClassName(Node $node)
    {
        $scope = $node->getAttribute(AttributeKey::SCOPE);
        if (! $scope instanceof Scope) {
            return null;
        }

        $classReflection = $scope->getClassReflection();
        if (! $classReflection instanceof ClassReflection) {
            return null;
        }

        $parentClassReflection = $classReflection->getParentClass();
        if ($parentClassReflection === false) {
            return null;
        }

        return $parentClassReflection->getName();
    }
}
