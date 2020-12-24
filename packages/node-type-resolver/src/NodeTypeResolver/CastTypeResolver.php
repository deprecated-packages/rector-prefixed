<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Cast;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class CastTypeResolver implements \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @required
     */
    public function autowireCastTypeResolver(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast::class];
    }
    /**
     * @param Cast $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->nodeTypeResolver->resolve($node->expr);
    }
}
