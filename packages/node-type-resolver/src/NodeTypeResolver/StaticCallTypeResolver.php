<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\NodeTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Type\Type;
use PHPStan\Type\TypeUtils;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class StaticCallTypeResolver implements \Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @required
     */
    public function autowireStaticCallTypeResolver(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function resolve(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        $classType = $this->nodeTypeResolver->resolve($node->class);
        $methodName = $this->nodeNameResolver->getName($node->name);
        // no specific method found, return class types, e.g. <ClassType>::$method()
        if (!\is_string($methodName)) {
            return $classType;
        }
        $classNames = \PHPStan\Type\TypeUtils::getDirectClassNames($classType);
        $scope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return $classType;
        }
        foreach ($classNames as $className) {
            if (!\method_exists($className, $methodName)) {
                continue;
            }
            return $scope->getType($node);
        }
        return $classType;
    }
}
