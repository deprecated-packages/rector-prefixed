<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\PropertyTypeResolverTest
 */
final class PropertyTypeResolver implements \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @required
     */
    public function autowirePropertyTypeResolver(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $propertyNode
     */
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node $propertyNode) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        // fake property to local PropertyFetch → PHPStan understands that
        $propertyFetch = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('this'), (string) $propertyNode->props[0]->name);
        $propertyFetch->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE, $propertyNode->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE));
        return $this->nodeTypeResolver->resolve($propertyFetch);
    }
}
