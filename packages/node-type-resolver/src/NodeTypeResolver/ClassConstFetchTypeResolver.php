<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\NodeTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PHPStan\Type\Type;
use Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class ClassConstFetchTypeResolver implements \Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @required
     */
    public function autowireClassConstFetchTypeResolver(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\PhpParser\Node\Expr\ClassConstFetch::class];
    }
    /**
     * @param ClassConstFetch $node
     */
    public function resolve(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        return $this->nodeTypeResolver->resolve($node->class);
    }
}
