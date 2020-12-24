<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\PropertyTypeResolverTest
 */
final class PropertyTypeResolver implements \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @required
     */
    public function autowirePropertyTypeResolver(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $propertyNode
     */
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $propertyNode) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        // fake property to local PropertyFetch → PHPStan understands that
        $propertyFetch = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('this'), (string) $propertyNode->props[0]->name);
        $propertyFetch->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE, $propertyNode->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE));
        return $this->nodeTypeResolver->resolve($propertyFetch);
    }
}
