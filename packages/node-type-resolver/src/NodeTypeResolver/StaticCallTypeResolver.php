<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
final class StaticCallTypeResolver implements \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @required
     */
    public function autowireStaticCallTypeResolver(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $classType = $this->nodeTypeResolver->resolve($node->class);
        $methodName = $this->nodeNameResolver->getName($node->name);
        // no specific method found, return class types, e.g. <ClassType>::$method()
        if (!\is_string($methodName)) {
            return $classType;
        }
        $classNames = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getDirectClassNames($classType);
        foreach ($classNames as $className) {
            if (!\method_exists($className, $methodName)) {
                continue;
            }
            /** @var Scope|null $nodeScope */
            $nodeScope = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            if ($nodeScope === null) {
                return $classType;
            }
            return $nodeScope->getType($node);
        }
        return $classType;
    }
}
