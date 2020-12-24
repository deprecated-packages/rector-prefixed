<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;
final class CastTypeResolver implements \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @required
     */
    public function autowireCastTypeResolver(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast::class];
    }
    /**
     * @param Cast $node
     */
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->nodeTypeResolver->resolve($node->expr);
    }
}
