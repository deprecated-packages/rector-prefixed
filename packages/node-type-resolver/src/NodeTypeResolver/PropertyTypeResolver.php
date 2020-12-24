<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\PropertyTypeResolverTest
 */
final class PropertyTypeResolver implements \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @required
     */
    public function autowirePropertyTypeResolver(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $propertyNode
     */
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $propertyNode) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        // fake property to local PropertyFetch → PHPStan understands that
        $propertyFetch = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('this'), (string) $propertyNode->props[0]->name);
        $propertyFetch->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE, $propertyNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE));
        return $this->nodeTypeResolver->resolve($propertyFetch);
    }
}
