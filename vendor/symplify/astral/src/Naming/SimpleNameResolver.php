<?php

declare (strict_types=1);
namespace RectorPrefix20210118\Symplify\Astral\Naming;

use RectorPrefix20210118\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Property;
use PHPStan\Analyser\Scope;
use RectorPrefix20210118\Symplify\Astral\Contract\NodeNameResolverInterface;
/**
 * @see \Symplify\Astral\Tests\Naming\SimpleNameResolverTest
 */
final class SimpleNameResolver
{
    /**
     * @var NodeNameResolverInterface[]
     */
    private $nodeNameResolvers = [];
    /**
     * @param NodeNameResolverInterface[] $nodeNameResolvers
     */
    public function __construct(array $nodeNameResolvers)
    {
        $this->nodeNameResolvers = $nodeNameResolvers;
    }
    /**
     * @param Node|string $node
     */
    public function getName($node) : ?string
    {
        if (\is_string($node)) {
            return $node;
        }
        foreach ($this->nodeNameResolvers as $nodeNameResolver) {
            if (!$nodeNameResolver->match($node)) {
                continue;
            }
            return $nodeNameResolver->resolve($node);
        }
        if ($node instanceof \PhpParser\Node\Expr\ClassConstFetch && $this->isName($node->name, 'class')) {
            return $this->getName($node->class);
        }
        if ($node instanceof \PhpParser\Node\Stmt\Property) {
            $propertyProperty = $node->props[0];
            return $this->getName($propertyProperty->name);
        }
        if ($node instanceof \PhpParser\Node\Expr\Variable) {
            return $this->getName($node->name);
        }
        return null;
    }
    /**
     * @param string[] $desiredNames
     */
    public function isNames(\PhpParser\Node $node, array $desiredNames) : bool
    {
        foreach ($desiredNames as $desiredName) {
            if ($this->isName($node, $desiredName)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param string|Node $node
     */
    public function isName($node, string $desiredName) : bool
    {
        $name = $this->getName($node);
        if ($name === null) {
            return \false;
        }
        if (\RectorPrefix20210118\Nette\Utils\Strings::contains($desiredName, '*')) {
            return \fnmatch($desiredName, $name);
        }
        return $name === $desiredName;
    }
    public function areNamesEqual(\PhpParser\Node $firstNode, \PhpParser\Node $secondNode) : bool
    {
        $firstName = $this->getName($firstNode);
        if ($firstName === null) {
            return \false;
        }
        return $this->isName($secondNode, $firstName);
    }
    public function getShortClassNameFromNode(\PhpParser\Node\Stmt\ClassLike $classLike) : ?string
    {
        $className = $this->getName($classLike);
        if ($className === null) {
            return null;
        }
        return $this->getShortClassName($className);
    }
    public function getShortClassName(string $className) : string
    {
        if (!\RectorPrefix20210118\Nette\Utils\Strings::contains($className, '\\')) {
            return $className;
        }
        return (string) \RectorPrefix20210118\Nette\Utils\Strings::after($className, '\\', -1);
    }
    public function getShortClassNameFromScope(\PHPStan\Analyser\Scope $scope) : ?string
    {
        $className = $this->getClassNameFromScope($scope);
        if ($className === null) {
            return null;
        }
        return $this->resolveShortName($className);
    }
    public function getClassNameFromScope(\PHPStan\Analyser\Scope $scope) : ?string
    {
        if ($scope->isInTrait()) {
            $traitReflection = $scope->getTraitReflection();
            if ($traitReflection === null) {
                return null;
            }
            return $traitReflection->getName();
        }
        $classReflection = $scope->getClassReflection();
        if ($classReflection === null) {
            return null;
        }
        return $classReflection->getName();
    }
    public function isNameMatch(\PhpParser\Node $node, string $desiredNameRegex) : bool
    {
        $name = $this->getName($node);
        if ($name === null) {
            return \false;
        }
        return (bool) \RectorPrefix20210118\Nette\Utils\Strings::match($name, $desiredNameRegex);
    }
    private function resolveShortName(string $className) : string
    {
        if (!\RectorPrefix20210118\Nette\Utils\Strings::contains($className, '\\')) {
            return $className;
        }
        return (string) \RectorPrefix20210118\Nette\Utils\Strings::after($className, '\\', -1);
    }
}
